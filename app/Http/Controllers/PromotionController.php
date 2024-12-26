<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use App\Models\School;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected PromotionService $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
        $this->middleware('auth');
    }

    // Ajoutez les autorisations manuellement dans chaque méthode
    public function index()
    {
        $this->authorize('viewAny', Promotion::class);
        $promotions = $this->promotionService->getPromotionsForUser(auth()->user());
        return view('promotions.index', compact('promotions'));
    }


    public function create()
    {
        $this->authorize('create', Promotion::class);
        // Si c'est un admin, on ne montre que son zécole
        if (auth()->user()->canManageOwnOptions()) {
            $schools = School::where('id', auth()->user()->school_id)->get();
        } // Si c'est un super admin, on montre toutes les écoles
        else {
            $schools = School::all();
        }
        return view('promotions.form', compact('schools'));
    }

    public function store(PromotionRequest $request)
    {
        $option = $this->promotionService->store($request->validated(), auth()->user());
        return redirect()->route('promotions.index')
            ->with('success', 'Promotion créée avec succès.');
    }

    public function edit(Promotion $promotion)
    {
        $schools = School::all();
        return view('promotions.form', compact('promotion', 'schools'));
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $this->promotionService->update($promotion, $request->validated());
        return redirect()->route('promotions.index')
            ->with('success', 'Promotion mise à jour avec succès.');
    }

    public function destroy(Promotion $promotion)
    {
        $this->promotionService->delete($promotion);
        return redirect()->route('promotions.index')
            ->with('success', 'Promotion supprimée avec succès.');
    }
}
