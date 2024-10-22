<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'images.*' => 'required|image',
            'images' => 'array|max:50'
        ],
        [
            'images.max' => 'Você pode enviar no máximo 50 imagens.',
        ]);

        $eventTitle = Str::slug($event->title);

        $eventFolder = public_path('img/gallery/' . $eventTitle);

        if (!file_exists($eventFolder)) {
            mkdir($eventFolder, 0755, true);
        }

        foreach ($request->file('images') as $image) {
            
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move($eventFolder, $imageName);

            Gallery::create([
                'event_id' => $event->id,
                'image_path' => $imageName,
                'image_folder' => $eventTitle
            ]);
        }

        return redirect()->back()->with('msg', 'Solicitação aprovada.');
    }
}
