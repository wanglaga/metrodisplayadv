<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategorySelector extends Component
{
    public $step = 1;
    public $selectedCategory1 = null; // nama kategori step 1
    public $selectedCategory2 = null; // nama kategori step 2
    public $loading = false;

    public $categoriesStep1 = []; // array nama kategori induk
    public $categoriesStep2 = []; // array nama kategori child

    public $result = null;

    public function mount()
    {
        // Ambil kategori yang tidak punya parent (parent_id = null) sebagai step 1
        $this->categoriesStep1 = Category::whereNull('parent_id')
            ->pluck('nama_kategori')
            ->toArray();
    }

    public function selectCategory1($category)
    {
        $this->loading = true;
        $this->selectedCategory1 = $category;
        $this->selectedCategory2 = null; // reset pilihan step 2
        $this->result = null; // reset hasil

        $this->dispatch('loading-start');

        // Ambil id kategori induk yang dipilih
        $parentId = $this->getCategoryIdByName($category);

        // Ambil kategori anak berdasarkan parent_id
        $this->categoriesStep2 = Category::where('parent_id', $parentId)
            ->pluck('nama_kategori')
            ->toArray();

        if (count($this->categoriesStep2) === 0) {
            // Tidak ada anak, langsung lompat ke hasil
            $this->selectedCategory2 = null;
            $this->step = 3;
            $this->result = "Hasil untuk {$this->selectedCategory1}";
            $this->loading = false;
            $this->dispatch('loading-end');
        } else {
            // Ada anak, lanjut ke step 2
            $this->step2Ready();
        }
    }


    protected function getCategoryIdByName($name)
    {
        return Category::where('nama_kategori', $name)->value('id');
    }

    public function step2Ready()
    {
        $this->loading = false;
        $this->step = 2;

        $this->dispatch('loading-end');
    }

    public function selectCategory2($category)
    {
        $this->loading = true;
        $this->selectedCategory2 = $category;

        $this->dispatch('loading-start');
        $this->showResultReady();
    }

    public function showResultReady()
    {
        $this->loading = false;
        $this->step = 3;
        $this->result = "Hasil untuk {$this->selectedCategory1} dan {$this->selectedCategory2}";

        $this->dispatch('loading-end');
    }

    public function render()
    {
        return view('livewire.category-selector');
    }
}
