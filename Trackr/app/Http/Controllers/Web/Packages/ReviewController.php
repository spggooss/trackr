<?php

namespace App\Http\Controllers\Web\Packages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Packages\Requests\ReviewCreateRequest;
use App\Models\Package\PackagesRepository;
use App\Models\Package\Review;
use App\Models\Package\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(private ReviewRepository $reviewRepository, private PackagesRepository $packagesRepository)
    {
    }

    public function index(Request $request): View
    {
        return view('packages.user.review')->with(['packageId' => $request->packageId]);
    }

    public function store(ReviewCreateRequest $request)
    {
        $review = new Review([
            'rating' => $request->getRating(),
            'comment' => $request->getComment(),
        ]);

        $review = $this->reviewRepository->store($review);

        $package = $this->packagesRepository->findById($request->getPackageId());
        $package->assignReview($review);

        return redirect()->action([PackagesController::class, 'packagesForUser']);
    }
}
