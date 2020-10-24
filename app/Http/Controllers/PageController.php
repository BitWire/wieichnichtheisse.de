<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webpatser\Uuid\Uuid;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{

    public function newPage(Request $request)
    {
        return View::make('new-page');
    }

    public function editPage(Request $request)
    {
        return View::make('edit-page');
    }

    public function savePage(Request $request)
    {
        $databaseService = new DatabaseService;
        $this->validate($request, [
            'name' => 'required | string',
            'altNames' => 'required|array',
        ]);
        $content['name'] = strip_tags($request->input('name'));
        $content['altNames'] = $request->input('altNames');
        foreach ($content['altNames'] as $key => $value) {
            $content['altNames'][$key] = strip_tags($value);
        }
        $uuid = $databaseService->create($content);
        Cookie::queue('uuid', $uuid, 25000);
        return View::make('save-page')->with(['uuid' => $uuid]);
    }

    public function updatePage(Request $request)
    {
        $databaseService = new DatabaseService;
        $this->validate($request, [
            'uuid' => 'required | uuid',
            'altNames' => 'required|array',
        ]);
        $content['uuid'] = strip_tags($request->input('uuid'));
        $content['altNames'] = $request->input('altNames');
        foreach ($content['altNames'] as $key => $value) {
            $content['altNames'][$key] = strip_tags($value);
        }
        $uuid = $databaseService->update($content);
        if ($uuid == false) {
            return response()->view(
                'error-page',
                [
                    'error' => Response::HTTP_NOT_FOUND,
                    'text' => 'ID not found or already deleted'
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        Cookie::queue('uuid', $uuid, 25000);
        return View::make('save-page')->with(['uuid' => $uuid]);
    }

    public function showPage(Request $request)
    {
        $this->validate($request, [
            $request->route('uuid') => 'uuid',
        ]);
        $uuid = $request->route('uuid');
        $databaseService = new DatabaseService;
        $entry = $databaseService->read($uuid);
        return View::make('show-page')->with(['name' => $entry['name'], 'altNames' => json_decode($entry['altNames'])]);
    }

    public function deletePage(Request $request)
    {
        return View::make('delete-page');
    }

    public function deleted(Request $request)
    {
        $databaseService = new DatabaseService;
        $this->validate($request, [
            'uuid' => 'required | uuid',
        ]);
        $uuid = strip_tags($request->input('uuid'));
        if ($databaseService->delete($uuid) == true) {
            return View::make('deleted');
        } else {
            return response()->view(
                'error-page',
                [
                    'error' => Response::HTTP_NOT_FOUND,
                    'text' => 'ID not found or already deleted'
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
