<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriePermi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriePermiController extends Controller
{
    public function index()
    {
        $categories = CategoriePermi::orderBy('label', 'asc')->get();
        return view('admin.categorie_permis.index', ['categories' => $categories]);
    }

    public function create()
    {
        // Redirect to index since we're using inline editing
        return redirect()->route('admin.categorie_permis.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255|unique:categorie_permis,label',
        ], [
            'label.required' => __('Le libellé est requis'),
            'label.unique' => __('Ce libellé existe déjà'),
        ]);

        try {
            CategoriePermi::create([
                CategoriePermi::LABEL_COLUMN => $validated['label'],
            ]);

            Alert::success(__('Succès'), __('Catégorie de permis créée avec succès'));
            return redirect()->route('admin.categorie_permis.index');
        } catch (\Exception $e) {
            Alert::error(__('Erreur'), __('Échec de la création de la catégorie: ') . $e->getMessage());
            return back();
        }
    }

    public function edit($id)
    {
        // Redirect to index since we're using inline editing
        return redirect()->route('admin.categorie_permis.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255|unique:categorie_permis,label,' . $id,
        ], [
            'label.required' => __('Le libellé est requis'),
            'label.unique' => __('Ce libellé existe déjà'),
        ]);

        try {
            $categorie = CategoriePermi::findOrFail($id);
            $categorie->update([
                CategoriePermi::LABEL_COLUMN => $validated['label'],
            ]);

            Alert::success(__('Succès'), __('Catégorie de permis mise à jour avec succès'));
            return redirect()->route('admin.categorie_permis.index');
        } catch (\Exception $e) {
            Alert::error(__('Erreur'), __('Échec de la mise à jour de la catégorie: ') . $e->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $categorie = CategoriePermi::findOrFail($id);
            
            // Check if category is used by any drivers
            if ($categorie->driver()->count() > 0) {
                Alert::error(__('Erreur'), __('Impossible de supprimer cette catégorie car elle est utilisée par des conducteurs'));
                return back();
            }

            $categorie->delete();
            Alert::success(__('Succès'), __('Catégorie de permis supprimée avec succès'));
            return redirect()->route('admin.categorie_permis.index');
        } catch (\Exception $e) {
            Alert::error(__('Erreur'), __('Échec de la suppression de la catégorie: ') . $e->getMessage());
            return back();
        }
    }
}

