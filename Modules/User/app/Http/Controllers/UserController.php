<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index(): Factory|View
   {
      return view('user::index');
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create(): Factory|View
   {
      return view('user::create');
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
   }

   /**
    * Show the specified resource.
    */
   public function show($id): Factory|View
   {
      return view('user::show');
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit($id): Factory|View
   {
      return view('user::edit');
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, $id)
   {
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
   }
}
