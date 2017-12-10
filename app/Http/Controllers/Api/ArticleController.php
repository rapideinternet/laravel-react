<?php
namespace App\Http\Controllers\Api;

use App\Repositories\Criteria\LatestCriterion;
use App\Repositories\Criteria\MineCriterion;
use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\Criteria\PublishedCriterion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{

    private $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LengthAwarePaginator|mixed
     */
    public function index(Request $request)
    {
        if ($request->user()->is_admin) {
            return $this->article->paginate();
        }
        return $this->article->getByCriteria(new MineCriterion())->paginate();
    }

    /**
     * get all published articles
     *
     * @return mixed
     */
    public function publishedArticles()
    {
        return $this->article
            ->pushCriteria(new LatestCriterion())
            ->pushCriteria(new PublishedCriterion())
            ->paginate();
    }

    /**
     * Get single published article
     *
     * @param $slug
     * @return mixed
     */
    public function publishedArticle($slug)
    {
        return $this->article->getByCriteria(new PublishedCriterion())->findBy('slug', $slug);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();
        $data['slug'] = str_slug($request->get('title'));

        $article = $this->article->fill($data);

        $user->articles()->save($article);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->user()->is_admin) {
            $this->article->pushCriteria(new MineCriterion())->find($id);
        }

        return $this->article->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = $this->article->find($id);

        $data = $request->validated();
        $data['slug'] = str_slug($request->get('title'));

        if ($this->article->update($id, $data)) {
            return response()->json($article->fresh(), 200);
        }

        return response()->json(['oops something went wrong!'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return ResponseFactory|JsonResponse|Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()) {
            return response()->json('You are not logged in', 401);
        }

        $article = $this->article->find($id);

        if ($article && ($article->id === $request->user()->id || $request->user()->is_admin)) {
            $this->article->delete($id);
            return response([], 200);
        }

        return response([], 400);
    }
}
