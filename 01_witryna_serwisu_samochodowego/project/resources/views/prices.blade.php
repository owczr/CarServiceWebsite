<x-app-layout>
    <style>

        body {
            font-family: 'lato', sans-serif;
        }
        .container {
            padding-top: 30px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 10px;
            padding-right: 10px;
        }

        h2 {
            font-size: 26px;
            margin: 20px 0;
            text-align: center;
        }

        li {
            border-radius: 3px;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        .table-header {
            background-color: #95A5A6;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .table-row {
            background-color: #ffffff;
            box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.1);
        }
        .col-1 {
            flex-basis: 10%;
        }
        .col-3 {
            flex-basis: 25%;
        }
        .col-4 {
            flex-basis: 25%;
        }

        @media all and (max-width: 767px) {
            .table-header {
                display: none;
            }
            .table-row{

            }
            li {
                display: block;
            }
            .col {

                flex-basis: 100%;

            }
            .col {
                display: flex;
                padding: 10px 0;
        }
        }
    </style>

    <div class="container">
        <!--
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">Job</div>
                <div class="col col-3">Amount Due</div>
                <div class="col col-4">Approximate time</div>
            </li>
            <li class="table-row">
                <div class="col col-1" data-label="Job">Breaks</div>
                <div class="col col-3" data-label="Amount">$150</div>
                <div class="col col-4" data-label="Payment Status">2 hours</div>
            </li>
            <li class="table-row">
                <div class="col col-1" data-label="Job">Tires</div>
                <div class="col col-3" data-label="Amount">$100</div>
                <div class="col col-4" data-label="Payment Status">1 hour</div>
            </li>
            <li class="table-row">
                <div class="col col-1" data-label="Job">Window tinting</div>
                <div class="col col-3" data-label="Amount">$50</div>
                <div class="col col-4" data-label="Payment Status">2 days</div>
            </li>
            <li class="table-row">
                <div class="col col-1" data-label="Job">Aplying PPF</div>
                <div class="col col-3" data-label="Amount">$1100</div>
                <div class="col col-4" data-label="Payment Status">3 days</div>
            </li>
        </ul>
        -->
        <table class="min-w-full divide-y divide-gray-200 mt-4">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Job
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Amount due
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Approximate time
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Breaks</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">$150</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">2 hours</div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Tires</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">$100</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">1 hour</div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Window tinting</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">$50</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">2 days</div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Aplying PPF</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">$1100</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">3 days</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>
