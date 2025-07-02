<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Training;

use App\TrainingMenu;

class TrainingController extends Controller
{
    public function showTrainingForm()
    {
        $menus = TrainingMenu::all();

        return view('trainings.training',compact('menus'));
    }

    public function recordTraining(Request $request)
    {
        $request->validate([
            'menu' => 'required|string|max:30',
            'parts' => 'required|string|max:20',
            'date' => 'required|date',
            'rep1' => 'nullable|numeric|min:0',
            'weight1' => 'nullable|numeric|min:0',
            'rep2' => 'nullable|numeric|min:0',
            'weight2' => 'nullable|numeric|min:0',
            'rep3' => 'nullable|numeric|min:0',
            'weight3' => 'nullable|numeric|min:0',
            'rep4' => 'nullable|numeric|min:0',
            'weight4' => 'nullable|numeric|min:0',
            'rep5' => 'nullable|numeric|min:0',
            'weight5' => 'nullable|numeric|min:0',
            'rep6' => 'nullable|numeric|min:0',
            'weight6' => 'nullable|numeric|min:0',
            'rep7' => 'nullable|numeric|min:0',
            'weight7' => 'nullable|numeric|min:0',
            'rep8' => 'nullable|numeric|min:0',
            'weight8' => 'nullable|numeric|min:0',
            'rep9' => 'nullable|numeric|min:0',
            'weight9' => 'nullable|numeric|min:0',
            'rep10' => 'nullable|numeric|min:0',
            'weight10' => 'nullable|numeric|min:0',
        ]);


        $request['user_id'] = Auth::id();

        Training::create([
            'user_id' => Auth::id(),
            'menu' => $request->menu,
            'parts' => $request->parts,
            'date' => $request->date,
            'weight1' => $request->weight1,
            'rep1' => $request->rep1,
            'weight2' => $request->weight2,
            'rep2' => $request->rep2,
            'weight3' => $request->weight3,
            'rep3' => $request->rep3,
            'weight4' => $request->weight4,
            'rep4' => $request->rep4,
            'weight5' => $request->weight5,
            'rep5' => $request->rep5,
            'weight6' => $request->weight6,
            'rep6' => $request->rep6,
            'weight7' => $request->weight7,
            'rep7' => $request->rep7,
            'weight8' => $request->weight8,
            'rep8' => $request->rep8,
            'weight9' => $request->weight9,
            'rep9' => $request->rep9,
            'weight10' => $request->weight10,
            'rep10' => $request->rep10,
        ]);


        return redirect()->route('main');
    }

    public function showTrainingMenuForm()
    {
        return view('trainings.trainingmenu');
    }

    public function recordTrainingMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
        ]);

        TrainingMenu::create([
            'name' => $request->name,
        ]);

        return redirect()->route('trainings.training');
    }
}
