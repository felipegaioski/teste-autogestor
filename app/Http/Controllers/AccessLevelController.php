<?php

namespace App\Http\Controllers;

use App\Models\AccessLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserPermissionCategory;

class AccessLevelController extends Controller
{
    public function get() {
        $user = auth()->user()->load('access_level');
        $access_levels = AccessLevel::all()->load('users');
        return view('site.access-levels.index', compact('user', 'access_levels'));
    }

    public function store(Request $request) 
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'name' => ['required', 'max:50'],
            ]);

            $access_level = AccessLevel::create($data);

            // UserPermission::create([
            //     'name' => 'Visualizar',
            //     'type' => 'view',
            //     'user_permission_category_id' => $access_level->id,
            // ])
            
            DB::commit();

        }
        catch (\Exception $e) {
            DB::rollBack();
            return($e);
        }

        return redirect('/niveis-de-acesso');
    }

    public function edit($id) 
    {
        $access_level = AccessLevel::find($id);
        $permission_categories = UserPermissionCategory::all()->load('permissions');
        if (is_null($access_level)) {
            return redirect('/niveis-de-acesso');
        }
        return view('site.access-levels.edit', compact('access_level', 'permission_categories'));
    }

    public function update(Request $request, $id) 
    {
        try {
            DB::beginTransaction();

            foreach ($request->input('permissions', []) as $permission_id => $permission_data) {
                $permissions[] = [
                    'id' => $permission_id,
                    'allow' => $permission_data['allow'] == '1' ? 1 : 0,
                ];
            }

            // info($permissions);

            $data = $request->validate([
                'name' => ['required', 'max:50'],
            ]);

            $access_level = AccessLevel::findOrFail($id);

            $access_level->update($data);

            if (!empty($permissions)) {
                $this->syncPermissions($access_level, $permissions);
            }

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return($e);
        }

        return redirect('/niveis-de-acesso');
    }

    // private function syncPermissions(AccessLevel $access_level, array $permissions)
    // {

    //     foreach ($permissions as $permission) {
    //         $sync_data[$permission['id']] = [
    //             'allow' => $permission['allow']
    //         ];
    //     }

    //     $access_level->permissions()->sync($sync_data);
    // }

    private function syncPermissions(AccessLevel $access_level, array $permissions)
    {
        // foreach ($permissions as $permission) {
        //     $access_level->permissions()->updateExistingPivot(
        //         $permission['id'],
        //         ['allow' => $permission['allow']]
        //     );
        // }
        foreach ($permissions as $permission) {
            $access_level->permissions()->syncWithoutDetaching([
                $permission['id'] => ['allow' => $permission['allow']]
            ]);
        }
    }

    public function new_permission_category($category_name, $category_type, $unique_permission = null, $unique_name = null)
    {
        $user_permission_category_id = null;

        $_category = DB::table('user_permission_categories')->where('type', $category_type);

        if ($_category->count() && $unique_permission == null) {
            dd('Já existe uma permissão com o tipo -> ' . $category_type);
        }

        $types = [];

        if ($_category->count() == 0) {
            $category = DB::table('user_permission_categories')->insertGetId([
                'name' => $category_name,
                'type' => $category_type,
            ]);
        }

        $user_permission_category_id = ($_category->count() > 0) ? collect($_category->get())->first()->id : $category;

        if ($unique_permission != null) {
            if (DB::table('user_permissions')->where('type', $unique_permission)->where('user_permission_category_id', $user_permission_category_id)->count()) {
                dd('Já existe a permissão ' . $unique_name . ' nesta categoria');
            }
            $types[$unique_permission] = $unique_name;
        } else {
            $types = ['view' => 'Visualizar', 'manage' => 'Gerenciar'];
            dump('Adicionado padrões');
            dump($types);
        }

        $access_levels = AccessLevel::all();

        $this->store_access_level_types($user_permission_category_id, $types, $access_levels);

        dump('success');
    }

    public function store_access_level_types($category, $types, $access_levels)
    {
        foreach ($types as $type => $name) {
            $user_permission = DB::table('user_permissions')->insertGetId([
                'name'                        => $name,
                'type'                        => $type,
                'user_permission_category_id' => $category,
            ]);

            foreach ($access_levels as $al) {
                if (
                    DB::table('access_level_user_permission')
                    ->where('access_level_id', $al->id)
                    ->where('user_permission_id', $user_permission)->count()
                ) {
                    continue;
                }

                DB::table('access_level_user_permission')->insertGetId([
                    'access_level_id'    => $al->id,
                    'user_permission_id' => $user_permission,
                    'allow'              => 0,
                ]);
            }
        }
    }
}
