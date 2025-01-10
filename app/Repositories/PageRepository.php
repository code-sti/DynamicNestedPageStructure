<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Support\Facades\DB;

class PageRepository
{
    /**
     * Fetch all pages with nested structure.
     *
     * @return mixed
     */
    public function getAllWithNested()
    {
        return Page::with('children')->whereNull('parent_id')->get();
    }

    /**
     * Find a page by ID with its children.
     *
     * @param int $id
     * @return Page|null
     */
    public function findByIdWithChildren($id)
    {
        return Page::with('children')->find($id);
    }

    /**
     * Find a page by slug and parent ID.
     *
     * @param string $slug
     * @param int|null $parentId
     * @return Page|null
     */
    public function findBySlugAndParent($slug, $parentId = null)
    {
        return Page::where('slug', $slug)
            ->where('parent_id', $parentId)
            ->first();
    }

    /**
     * Create a new page.
     *
     * @param array $data
     * @return Page
     */
    public function create(array $data)
    {
        return Page::create($data);
    }

    /**
     * Update an existing page by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        $page = Page::find($id);
        if (!$page) {
            return false;
        }

        return $page->update($data);
    }

    /**
     * Delete a page by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return false;
        }

        return DB::transaction(function () use ($page) {
            // Delete all nested children
            $this->deleteNested($page->id);

            // Delete the page itself
            return $page->delete();
        });
    }

    /**
     * Recursively delete all nested children of a page.
     *
     * @param int $parentId
     * @return void
     */
    private function deleteNested($parentId)
    {
        $children = Page::where('parent_id', $parentId)->get();

        foreach ($children as $child) {
            $this->deleteNested($child->id);
            $child->delete();
        }
    }
}
