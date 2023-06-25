@extends('layouts.app')
@section('content')
<div class="relative">
    <div class="absolute h-full w-full opacity-80 bg-red-200">
    </div>
    <div class="absolute h-full w-1/2 bg-green-300 text-center left-1/2 transform -translate-x-1/2">
        <p class="text-right pr-6 pt-2 text-2xl hover:cursor-pointer">x</p>
        <h2 class="text-4xl pt-4">Welcome to Teach-BOT!</h2>
        <div class="bg-green-200 border-2 border-green-300 w-1/2 mx-auto mt-8 py-2">
            <h3>What is Teach-BOT?</h3>
        </div>
        <div class="bg-green-200 border-2 border-green-300 w-1/2 mx-auto py-2">
            <h3>FAQ's</h3>
        </div>
        <div class="rounded-full bg-pink-200 h-1/3 w-1/2 mx-auto p-2 mt-12">
            <div class="bg-pink-100 border-2 border-green-300 w-1/2 mx-auto py-2 mt-4 hover:bg-pink-50">
                <form action="{{ route('login') }}" method="GET">
                    <button type="submit">Login</button>
                </form>
            </div>
            <div class="bg-pink-100 border-2 border-green-300 w-1/2 mx-auto py-2 mt-2 hover:bg-pink-50">
                <form action="{{ route('register') }}" method="GET">
                    <button type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3">
        <div>
            <div class="bg-green-200 pl-2 h-24">
                <h2 class="text-3xl pl-2 pt-6">Orangise</h2>
            </div>
            <div class="bg-green-300 pl-2 h-24">
                <h2 class="text-3xl pl-2 pt-6">Plan</h2>
            </div>
            <div class="bg-green-200 pl-2 h-24">
                <h2 class="text-3xl pl-2 pt-6">Report</h2>
            </div>
            <div class="bg-green-300 pl-2 h-24">
                <h2 class="text-3xl pl-2 pt-6">Train</h2>
            </div>
            <div class="bg-green-200 pl-2 h-24">
                <h2 class="text-3xl pl-2 pt-6">Assess</h2>
            </div>
        </div>
        <!--Temporary Calender-->
        <div class="col-span-2">
            <div class="grid grid-cols-5 h-24">
                <div class="bg-pink-200 pl-2">
                    <h2></h2>
                </div>
                <div class="bg-pink-300 pl-2">
                    <h2>1</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>2</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>3</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>4</h2>
                </div>
            </div>
            <div class="grid grid-cols-5 h-24">
                <div class="pl-2 bg-pink-300">
                    <h2>7</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>8</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>9</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>10</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>11</h2>
                </div>
            </div>
            <div class="grid grid-cols-5 h-24">
                <div class="pl-2 bg-pink-200">
                    <h2>14</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>15</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>16</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>17</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>18</h2>
                </div>
            </div>
            <div class="grid grid-cols-5 h-24">
                <div class="pl-2 bg-pink-300">
                    <h2>21</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>22</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>23</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>24</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>25</h2>
                </div>
            </div>
            <div class="grid grid-cols-5 h-24">
                <div class="pl-2 bg-pink-200">
                    <h2>28</h2>
                </div>
                <div class="pl-2 bg-pink-300">
                    <h2>29</h2>
                </div>
                <div class="pl-2 bg-pink-200">
                    <h2>30</h2>
                </div>
                <div class="pl-2 bg-pink-300">
            
                </div>
                <div class="pl-2 bg-pink-200">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- <form action="/chat" method="POST">
    @csrf
    <div>
        <p class="p-4 bg-orange-400 text-white">Begin creating quick and easy worksheets for your classes. Select the options below: </p>
        <div class="mt-4 mx-4 w-1/2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white underline" for="lessons">Number of Lessons:</label>
            <select name="lessons[]" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
        </div>
        <div class="mx-4 w-1/2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white underline" for="year">Select a Year Group:</label>
            <select name="year[]" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="Year 7">Year 1</option>
                <option value="Year 8">Year 2</option>
                <option value="Year 9">Year 3</option>
                <option value="Year 10">Year 4</option>
                <option value="Year 11">Year 5</option>
            </select>
        </div>
        <div class="mx-4 w-1/2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white underline" for="subject">Select a Topic:</label>
            <select name="subject[]" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="Reading Comprehension">Reading Comprehension</option>
                <option value="Adding and Subtracting Fractions">Adding and Subtracting Fractions</option>
                <option value="Factorising Expressions">Factorising Expressions</option>
                <option value="Expanding Brackets">Expanding Brackets</option>
                <option value="Multiplying Fractions">Multiplying Fractions</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white mx-4 px-4 py-1 w-1/3 my-4">Send</button>
    </div>
</form> -->
@endsection


