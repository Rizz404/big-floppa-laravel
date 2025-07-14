<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserLayout extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $ogImage;
    public $showHeader;
    public $showFooter;
    public $containerClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title = "",
        string $description = "",
        string $keywords = "",
        string $ogImage = "",
        bool $showHeader = true,
        bool $showFooter = true,
        string $containerClass = ""
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->ogImage = $ogImage;
        $this->showHeader = $showHeader;
        $this->showFooter = $showFooter;
        $this->containerClass = $containerClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.user-layout');
    }
}
