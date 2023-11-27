<?php

namespace App\Http\Controllers\Web\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Admin\Requests\CreateUserRequest;
use App\Http\Controllers\Web\Admin\Requests\UpdateUserRequest;
use App\Http\Controllers\Web\GeneralRequests\PaginatedRequest;
use App\Http\Controllers\Web\GeneralRequests\SortingRequest;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Models\User\UsersRepository;
use App\Models\Webshop\WebshopsRepository;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(private UsersRepository $usersRepository, private WebshopsRepository $webshopsRepository)
    {
        $this->middleware('auth');
    }

    public function index(PaginatedRequest $request, SortingRequest $sortingRequest)
    {
        $users = $this->usersRepository->getPaged(
            $request->getPage(),
            $request->getLimit(),
            $sortingRequest->getOrderBy() ?? 'id',
            $sortingRequest->getOrderDirection() ?? 'asc',
            $sortingRequest->getSearchTerm() ?? '',
        );

        return view('super_admin.users.index',
            [
                'search' => $request->get('search') ?? '',
                'users' => $users,
                'page' => $request->getPage() ?? 1,
                'limit' => $request->getLimit() ?? 5,
                'sort' => $sortingRequest->getSort(),
            ]
        );
    }

    public function create()
    {
        $webshops = $this->webshopsRepository->all();

        return view('super_admin.users.create')->with(['roles' => UserRole::getAll(), 'webshops' => $webshops]);
    }

    public function store(CreateUserRequest $request)
    {
        $user = new User([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getPassword()),
        ]);
        $this->usersRepository->store($user);
        $user->assignRole($request->getRole());
        $webshop = $this->webshopsRepository->findById($request->getWebshopId());
        $user->assignWebshop($webshop);

        return redirect()->route('super-admin.users.index');
    }

    public function edit(int $userId)
    {
        $user = $this->usersRepository->findById($userId);
        $webshops = $this->webshopsRepository->all();

        return view('super_admin.users.edit')->with(['user' => $user, 'roles' => UserRole::getAll(), 'webshops' => $webshops]);
    }

    public function update(int $userId, UpdateUserRequest $request)
    {
        $user = $this->usersRepository->findById($userId);
        $user->name = $request->getName();
        $webshop = $this->webshopsRepository->findById($request->getWebshopId());
        $user->assignWebshop($webshop);
        $user->assignRole($request->getRole());

        $this->usersRepository->store($user);

        return redirect()->route('super-admin.users.index');
    }
}
