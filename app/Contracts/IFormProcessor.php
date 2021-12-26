<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface IFormProcessor
{
    public function filter(Request $request);
    public function show($id);
    public function edit($id);
    public function store(Request $request);
    public function update(Request $request, $id);
    // public function batchUpdate(Request $request);
    public function destroy($id);
    public function deleteMulti(Request $request);
    public function mapService();
    // public function batchDestroy(Request $request);
}
