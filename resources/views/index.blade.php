<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="container mx-auto mt-10 mb-10 max-w-3xl">

   @foreach ($klasses as $klass )
        {{-- @foreach ($klass->sectionYears as $sy)
            <h1>{{$sy->s_y}}</h1>
        @endforeach --}}
        @dd($klass->sectionYears)
   @endforeach
    {{-- <div class="overflow-auto rounded-lg shadow hidden md:block">
        <table class="w-full">
          <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr>
            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Criteria</th>
            <th class="p-3 text-sm font-semibold tracking-wide text-left"></th>
            <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">NI</th>
            <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">F</th>
            <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">S</th>
            <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">VS</th>
            <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">O</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
          <tr class="bg-white">
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
            </td>
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
              question
            </td>
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                22
            </td>
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">23</td>
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">22</td>
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">22</td>
            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">22</td>
          </tr>
          </tbody>
        </table>
      </div> --}}

</body>
</html>
