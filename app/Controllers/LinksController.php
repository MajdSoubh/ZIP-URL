<?php

namespace App\Controllers;

use App\Models\Link;
use Core\Support\Str;
use Core\Validation\Validator;

class LinksController
{

    public function store()
    {
        $rules = [
            'url' => 'required|url',
            'slug' => 'required|min:1|unique:links,slug',
        ];
        $aliases = ['slug' => 'Slug', 'url' => 'URL'];
        $validator = new Validator();

        $validator->make(request()->all(), $rules, $aliases);

        if ($validator->fails())
        {
            session()->setFlash('errors', $validator->errors());
            session()->setFlash('old', request()->all());
            return back();
        }

        request()->set('slug', Str::slug(request('slug')));

        Link::create(array_merge(request()->all(), ['user_id' => auth()->user()->id]));

        session()->setFlash('messages', ['Link saved successfully.', 'Use the Shortened URL: ' . env('APP_URL') . '/' . request()->get('slug')]);

        return back();
    }

    public function delete($id)
    {
        $link = Link::where(['id', '=', $id])->first();

        if (empty($link))
        {
            session()->setFlash('messages', ['The requested Link does not exist.']);

            return back();
        }

        Link::delete($id);

        session()->setFlash('messages', ['Link deleted successfully.']);

        return back();
    }

    public function getUrlBySlug($linkSlug)
    {

        $link = Link::where(['slug', '=', $linkSlug])->first();
        if (empty($link))
        {

            return view('errors.slug_not_found', null, ['slug' => $linkSlug]);
        }

        return redirect($link['url']);
    }
    public function links()
    {

        $links = Link::where(['user_id', '=', auth()->user()->id])->get();

        return view('links', 'BaseLayout', ['links' => $links]);
    }
}
