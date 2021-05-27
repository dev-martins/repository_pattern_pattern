<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateUser;
use App\Repositories\Contracts\UserRepositoryInterface;

class UsersController extends Controller
{
    protected $user;
    protected $repository;

    public function __construct(UserRepositoryInterface $repository, User $user)
    {
        $this->user = $user;
        $this->repository = $repository;
    }

    public function getUsers()
    {
        try {
            // $users = $this->user->all();
            $users = $this->repository->orderBy('name')->getAll();
            return response()->json($users, 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function getUser($id)
    {
        try {
            $user = $this->repository->findById($id);
            if (is_null($user))
                return response()->json(['msg' => 'Usuário não encontrado!'], 404);
            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function storeUser(CreateUpdateUser $request)
    {
        try {
            $data = $request->input();
            $data['password'] = bcrypt($data['password']);
            $this->repository->store($data);
            return response()->json(['msg' => 'Usuário cadastrado!'], 201);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function updateUser(CreateUpdateUser $request, $id)
    {
        try {

            $user = $this->user->find($id);
            if (is_null($user))
                return response()->json(['msg' => 'Usuário não encontrado!'], 404);
            else
                $data = $request->input();
            if ($request->password) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data["password"]);
            }
            $this->repository->update($id, $data);
            return response()->json(['msg' => 'Cadastro atualizado!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function deleteUser($id)
    {

        try {
            $user = $this->user->find($id);
            if (is_null($user))
                return response()->json(['msg' => 'Usuário não econtrado!'], 404);
            else
                $this->repository->delete($id);
            return response()->json(['msg' => 'Cadastro removido!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function searchUser(Request $request)
    {
        $users = $this->repository->search($request->input());
        return $users;
    }
}
