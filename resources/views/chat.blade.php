@extends('layouts.app')
@section('content')
<form action="/chat" method="POST">
    @csrf
    <div>
        <p class="p-4 bg-orange-400 text-white">Begin creating quick and easy worksheets for your classes. Select the options below: </p>
        <div class="mt-4 mx-4 w-1/3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="questions">Number of Questions:</label>
            <select name="questions[]" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
        <div class="mx-4 w-1/3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="year">Select a Year Group:</label>
            <select name="year[]" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="Year 7">Year 7</option>
                <option value="Year 8">Year 8</option>
                <option value="Year 9">Year 9</option>
                <option value="Year 10">Year 10</option>
                <option value="Year 11">Year 11</option>
            </select>
        </div>
        <div class="mx-4  w-1/3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="subject">Select a Topic:</label>
            <select name="subject[]" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="Solving Equations">Solving Equations</option>
                <option value="Adding and Subtracting Fractions">Adding and Subtracting Fractions</option>
                <option value="Factorising Expressions">Factorising Expressions</option>
                <option value="Expanding Brackets">Expanding Brackets</option>
                <option value="Multiplying Fractions">Multiplying Fractions</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white mx-4 px-4 py-1 w-1/3">Send</button>
    </div>
</form>
@endsection


