<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\SubscriptionPlan;
use App\Models\FineTuneModel;

class OriginalChatModels extends Component
{
    public $models;
    public $fine_tunes;
    public $default_model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        # Apply proper model based on role and subsciption
        if (auth()->user()->group == 'user') {
            $models = explode(',', config('settings.free_tier_models'));
        } elseif (!is_null(auth()->user()->plan_id)) {
            $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
            $models = explode(',', $plan->model_chat);
        } else {            
            $models = explode(',', config('settings.free_tier_models'));
        }

        $this->models = $models;
        $this->fine_tunes = FineTuneModel::all();
        $this->default_model = auth()->user()->default_model_chat;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.original-chat-models');
    }
}