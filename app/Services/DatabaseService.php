<?php

namespace App\Services;

use Webpatser\Uuid\Uuid;
use App\Pages;

class DatabaseService
{
    public function create(array $data)
    {
        $uuid = Pages::create(['name' => $data['name'], 'altNames' => json_encode($data['altNames'])])->uuid;
        return $uuid;
    }

    public function read(string $uuid)
    {
        return Pages::find($uuid);
    }

    public function update(array $data)
    {
        $page = Pages::find($data['uuid']);
        if (empty($page)) {
            return false;
        }
        $blob = json_decode($page->altNames);
        $blob = array_merge($blob, $data['altNames']);
        $page->altNames = json_encode($blob);
        $page->save();
        return $data['uuid'];
    }

    public function delete(string $uuid)
    {
        $page = Pages::find($uuid);
        if (!empty($page)) {
            $page->delete();
            return true;
        }
        return false;
    }
}
