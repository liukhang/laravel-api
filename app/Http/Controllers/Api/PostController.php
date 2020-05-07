<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? config('app.paginate.per_page');
            $orderBys = [];
            if ($request->get('column') && $request->get('sort')) {
                $orderBys['column'] = $request->get('column');
                $orderBys['sort'] = $request->get('sort');
            }

            $postPaginate = $this->postService->getAll($orderBys, $limit);

            return response()->json([
                'status'    => true,
                'code'      => Response::HTTP_OK,
                'post'      => $postPaginate->items(),
                'meta'      => [
                    'total'         => $postPaginate->total(),
                    'perPage'       => $postPaginate->perPage(),
                    'currentPage'   => $postPaginate->currentPage(),
                ]   
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $post = $this->postService->save(['name' => $request->name]);
            return response()->json([
                'status'    => true,
                'code'      => Response::HTTP_OK,
                'post'      => $post,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = $this->postService->save(['name' => $request->name], $id);
            return response()->json([
                'status'    => true,
                'code'      => Response::HTTP_OK,
                'post'      => $post,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        try {
            $post = $this->postService->findByID($id);
            return response()->json([
                'status'    => true,
                'code'      => Response::HTTP_OK,
                'post'      => $post,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->postService->delete($id);
            return response()->json([
                'status'    => true,
                'code'      => Response::HTTP_OK,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'   => $e->getMessage(),
            ]);
        }
    }
}
