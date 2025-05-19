<div class="max-w-7xl mx-auto px-4 py-12">
    <h2 class="text-2xl font-bold underline mb-8">R. SARABIA OPTICAL BRANCHES</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
            $branches = [
                [
                    'name' => 'Sta. Elena Branch',
                    'address' => '#187 Shoe. Ave. Brgy. Sta Elena, Marikina City',
                    'tel' => '027956-6679',
                    'mobile' => '09269060613',
                ],
                [
                    'name' => 'Phil. Trust Branch',
                    'address' => '#23 Phil. Trust Bank Bldg. Sumulong Hi-way cor. P. Burgos St. Brgy. Sto. Nino, Marikina City',
                    'tel' => '027949-0061',
                    'mobile' => '09550618296',
                ],
                [
                    'name' => 'Pasig Branch',
                    'address' => '#34-A Mabini St. Brgy. Kapasigan, Pasig City',
                    'tel' => '027002-2998',
                    'mobile' => '09269060760',
                ],
                [
                    'name' => 'Masinag Branch',
                    'address' => '#272 Sumulong Hi-way Brgy. Mayamot, Antipolo City',
                    'tel' => '088470-8822',
                    'mobile' => '09269060726',
                ],
                [
                    'name' => 'SM Center Downtown Antipolo',
                    'address' => '2nd floor SM Center Downtown Antipolo, Marcos Hi-way Brgy. Mayamot, Antipolo City',
                    'tel' => '028330-7791',
                    'mobile' => '09338680057',
                ]
            ];
        @endphp

        @foreach ($branches as $branch)
        <div class="space-y-2">
            <h3 class="text-lg font-semibold text-red-900">R. Sarabia Optical – {{ $branch['name'] }}</h3>
            <p class="text-gray-800"><span class="font-semibold">Address:</span> {{ $branch['address'] }}</p>
            <p class="text-gray-800"><span class="font-semibold">Tel. No.:</span> {{ $branch['tel'] }}</p>
            <p class="text-gray-800"><span class="font-semibold">Mobile No.:</span> {{ $branch['mobile'] }}</p>
            <a href="#" class="text-red-900 font-bold">BOOK AN APPOINTMENT</a>
        </div>
        @endforeach
    </div>

</div>
