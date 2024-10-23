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
            'images.*'  => 'required|image',
            'images'    => 'array|max:50'
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
                'event_id'      => $event->id,
                'image_path'    => $imageName,
                'image_folder'  => $eventTitle
            ]);
        }

        return redirect()->back()->with('msg', 'Imagens do evento salva com sucesso!!');
    }

    public function destroy($id)
    {
        $image      = Gallery::findOrFail($id);
        $imagePath  = public_path('img/gallery/' . $image->image_folder . '/' . $image->image_path);
        
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $image->delete();

        return redirect()->back()->with('msg', 'Imagem excluída com sucesso.');
    }

    public function deleteAll($eventFolder)
    {
        $eventFolderPath = public_path('img/gallery/' . $eventFolder);

        if (file_exists($eventFolderPath)) {
            
            $files = glob($eventFolderPath . '/*');

            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            
            rmdir($eventFolderPath);
        }
        
        Gallery::where('image_folder', $eventFolder)->delete();

        return redirect()->back()->with('msg', 'Todas as imagens e a pasta foram excluídas com sucesso.');
    }
}
