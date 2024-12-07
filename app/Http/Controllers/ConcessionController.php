<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ConcessionController extends Controller
{
    protected $concessionRepository;

    public function __construct(ConcessionRepositoryInterface $concessionRepository)
    {
        //passed in repsoitory instance is being stored in the class property $concessionRepository
        $this->concessionRepository = $concessionRepository;
    }

    //get all concessions via the repo function and parse it to the view as an associative array
    public function index()
    {
        $concessions = $this->concessionRepository->getAll();
        return view('concessions.index', compact('concessions'));
    }

    //return the view for creating concessions
    public function create()
    {
        return view('concessions.create');
    }

    //validating and parsing the validated data to the create function in repo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();

        //the image key of the data array will contain the path of the image
        $data['image'] = $request->file('image')->store('concessions', 'public');
        $this->concessionRepository->create($data);

        //redirect to the index function
        return redirect()->route('concessions.index');
    }

    // The id of a single concession is parsed in from the view finally to the find method in repo
    // A concession with its stored details is sent to the edit view as an associative array
    public function edit($id)
    {
        $concession = $this->concessionRepository->find($id);
        return view('concessions.edit', compact('concession'));
    }

    //validating and parsing the validated data to the update function in repo
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        //checks if a file has been uploaded and if yes, it will update the image key of the data array
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('concessions', 'public');
        }
        $this->concessionRepository->update($id, $data);

        return redirect()->route('concessions.index');
    }

    // The id of a single concession is parsed in from the view finally to the delete method in repo
    // The relevant image is also deleted
    // After that it is redirected to the index function
    public function destroy($id)
    {
        $concession = $this->concessionRepository->find($id);
        if ($concession->image) {
            Storage::disk('public')->delete($concession->image); // Assuming the image path is stored in 'image' column
        }
        $this->concessionRepository->delete($id);
        return redirect()->route('concessions.index');
    }
}
