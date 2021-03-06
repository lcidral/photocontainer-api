<?php

namespace PhotoContainer\PhotoContainer\Contexts\Search\Persistence;

use PhotoContainer\PhotoContainer\Contexts\Search\Domain\Category;
use PhotoContainer\PhotoContainer\Contexts\Search\Domain\EventRepository;
use PhotoContainer\PhotoContainer\Contexts\Search\Domain\EventSearch;
use PhotoContainer\PhotoContainer\Contexts\Search\Domain\Photographer;
use PhotoContainer\PhotoContainer\Infrastructure\Persistence\Eloquent\EventSearch as EventSearchModel;

class EloquentEventRepository implements EventRepository
{
   public function find(EventSearch $search)
    {
        try {
            $where = [];

            if ($search->getTitle()) {
                $where[] = ['title', 'like', "%".$search->getTitle()."%"];
            }

            if ($search->getPhotographer()->getId()) {
                $where[] = ['user_id', $search->getPhotographer()->getId()];
            }

            $allCategories = $search->getCategories();
            if ($allCategories) {
                $categories = [];
                foreach ($allCategories as $category) {
                    $categories[] = $category->getId();
                }

                $where[] = ['category_id', $categories];
            }

            $allTags = $search->getTags();
            if ($allTags) {
                $tags = [];
                foreach ($allTags as $tag) {
                    $tags[] = $tag->getId();
                }

                $where[] = ['tag_id', $tags];
            }

            $eventSearch = EventSearchModel::where($where)
                ->groupBy('id', 'category_id', 'category')
                ->get(['id', 'user_id', 'name', 'title', 'eventdate', 'category_id', 'category']);

            return $eventSearch->map(function ($item, $key) {
                $category = new Category($item->category_id, $item->category);
                $photographer = new Photographer($item->user_id, $item->name);

                $search = new EventSearch($item->id, $photographer, $item->title, [$category], null);
                $search->changeEventdate($item->eventdate);

                return $search;
            })->toArray();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }


}