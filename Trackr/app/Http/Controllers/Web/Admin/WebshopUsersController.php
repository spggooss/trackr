<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Admin\Requests\CreateUserRequest;
use App\Http\Controllers\Web\Admin\Requests\UpdateUserRequest;
use App\Http\Controllers\Web\GeneralRequests\PaginatedRequest;
use App\Http\Controllers\Web\GeneralRequests\SortingRequest;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Models\User\UsersRepository;
use App\Models\Webshop\Webshop;
use App\Models\Webshop\WebshopsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebshopUsersController extends Controller
{
    public function __construct(private UsersRepository $usersRepository, private WebshopsRepository $webshopsRepository)
    {
        $this->middleware('auth');
    }

    public function index(PaginatedRequest $request, SortingRequest $sortingRequest)
    {
        $users = $this->usersRepository->getPagedForWebshop(
            Auth::guard()->user()->webshop,
            $request->getPage(),
            $request->getLimit(),
            $sortingRequest->getOrderBy() ?? 'id',
            $sortingRequest->getOrderDirection() ?? 'asc',
            $sortingRequest->getSearchTerm() ?? '',
        );

        return view('admin.users.index',
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
        return view('admin.users.create')->with(['roles' => [UserRole::WEB_SHOP_ADMIN, UserRole::EDITOR, UserRole::PACKAGE_HANDLER]]);
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
        $webshop = $this->webshopsRepository->findById(Auth::guard()->user()->webshop_id);
        $user->assignWebshop($webshop);

        return redirect()->route('admin.webshop.users.index', ['webshop' => $webshop]);
    }

    public function edit(Webshop $webshop, int $userId)
    {
        $user = $this->usersRepository->findById($userId);
        $webshops = $this->webshopsRepository->all();

        return view('admin.users.edit')->with(['user' => $user, 'roles' => [UserRole::WEB_SHOP_ADMIN, UserRole::EDITOR, UserRole::PACKAGE_HANDLER], 'webshops' => $webshops]);
    }

    public function update(Webshop $webshop, int $userId, UpdateUserRequest $request)
    {
        $user = $this->usersRepository->findById($userId);
        $user->name = $request->getName();
        $user->assignRole($request->getRole());

        $this->usersRepository->store($user);

        return redirect()->route('admin.webshop.users.index', ['webshop' => $webshop]);
    }
}
