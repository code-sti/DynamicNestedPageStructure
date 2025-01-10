<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class PageController extends Controller
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Fetch all pages with nested structure.
     */
    public function index()
    {
        try {
            $pages = $this->pageRepository->getAllWithNested();
            return response()->json($pages);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch pages.'], 500);
        }
    }

    /**
     * Fetch a single page by ID with its children.
     */
    public function show($id)
    {
        try {
            $page = $this->pageRepository->findByIdWithChildren($id);

            if ($page) {
                return response()->json($page);
            } else {
                return response()->json(['error' => 'Page not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch page.'], 500);
        }
    }

    /**
     * Create a new page.
     */
    public function store(StorePageRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $page = $this->pageRepository->create($data);
            DB::commit();

            return response()->json(['message' => 'Page created successfully.', 'data' => $page], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create page.'], 500);
        }
    }

    /**
     * Update an existing page.
     */
    public function update(UpdatePageRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $updated = $this->pageRepository->update($id, $data);

            if ($updated) {
                DB::commit();
                return response()->json(['message' => 'Page updated successfully.']);
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Page not found.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update page.'], 500);
        }
    }

    /**
     * Delete a page by ID.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $deleted = $this->pageRepository->delete($id);

            if ($deleted) {
                DB::commit();
                return response()->json(['message' => 'Page deleted successfully.']);
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Page not found.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete page.'], 500);
        }
    }

    public function resolveNestedPage($path)
    {
        $slugArray = explode('/', $path); // Split the slug into an array of segments

        $parentPage = null;
        $pagesData = []; // Array to hold all pages in the hierarchy

        foreach ($slugArray as $slug) {
            // Find the page with the matching slug and parent_id (if any)
            $parentPage = Page::where('slug', $slug)
                ->where('parent_id', optional($parentPage)->id)
                ->get(); // Get only the first matching page

            // If no page is found at this level, return a 404 error
            if (!$parentPage) {
                return response()->json(['message' => 'Page not found'], 404);
            }

            // Add the current page to the pages data array
            $pagesData[] = $parentPage;
        }

        // Return all the pages found in the hierarchy
        return response()->json($pagesData);
    }
}
