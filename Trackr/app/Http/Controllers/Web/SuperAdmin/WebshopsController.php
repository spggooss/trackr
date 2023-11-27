<?php

namespace App\Http\Controllers\Web\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\GeneralRequests\PaginatedRequest;
use App\Http\Controllers\Web\GeneralRequests\SortingRequest;
use App\Http\Controllers\Web\SuperAdmin\Requests\CreateWebshopRequest;
use App\Models\Webshop\Webshop;
use App\Models\Webshop\WebshopsRepository;

class WebshopsController extends Controller
{
    public function __construct(private WebshopsRepository $webshopsRepository)
    {
        $this->middleware('auth');
    }

    public function index(PaginatedRequest $request, SortingRequest $sortingRequest)
    {
        $webshops = $this->webshopsRepository->getPaged(
            $request->getPage(),
            $request->getLimit(),
            $sortingRequest->getOrderBy() ?? 'id',
            $sortingRequest->getOrderDirection() ?? 'asc',
            $sortingRequest->getSearchTerm() ?? '',
        );

        return view('super_admin.webshops.index',
            [
                'search' => $request->get('search') ?? '',
                'webshops' => $webshops,
                'page' => $request->getPage() ?? 1,
                'limit' => $request->getLimit() ?? 5,
                'sort' => $sortingRequest->getSort(),
            ]
        );
    }

    public function create()
    {
        return view('super_admin.webshops.create');
    }

    public function store(CreateWebshopRequest $request)
    {
        $webshop = new Webshop([
            'name' => $request->getName(),
        ]);
        $this->webshopsRepository->store($webshop);


        return redirect()->route('super-admin.webshops.index');
    }
}
