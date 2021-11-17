<div style="margin-left:auto;margin-right:auto;">
    <style media="all">
        @page {
            margin: 0;
            padding:0;
        }
        *{
            margin: 0;
            padding: 0;
        }
        body{
            line-height: 1.5;
            font-family: 'DejaVuSans', 'sans-serif';
            color: #333542;
        }
        div{
            font-size: 1rem;
        }
        .gry-color *,
        .gry-color{
            color:#878f9c;
        }
        table{
            width: 100%;
        }
        table th{
            font-weight: normal;
        }
        table.padding th{
            padding: .5rem .7rem;
        }
        table.padding td{
            padding: .7rem;
        }
        table.sm-padding td{
            padding: .2rem .7rem;
        }
        .border-bottom td,
        .border-bottom th{
            border-bottom:1px solid #eceff4;
        }
        .text-left{
            text-align:left;
        }
        .text-right{
            text-align:right;
        }
        .small{
            font-size: .85rem;
        }
        .strong{
            font-weight: bold;
        }
    </style>

        @php
            $logo = get_setting('header_logo');
        @endphp

        <div style="background: #eceff4;padding: 1.5rem;">
            <table>
                <tr>
                    <td>
                        @if($logo != null)
                            <img src="{{ uploaded_asset($logo) }}" height="40" style="display:inline-block;">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" height="40" style="display:inline-block;">
                        @endif
                    </td>
                </tr>
            </table>

        </div>

        <div style="border-bottom:1px solid #eceff4;margin: 0 1.5rem;"></div>

        <div style="padding: 1.5rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th width="20%">{{translate('File') }}</th>
                        <th width="60%">{{translate('File Name') }}</th>
                        <th width="20%">{{translate('ID') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @foreach ($pdfs as $key => $pdf)
                        <tr class="">
                            <td>
                                <a href="{{ my_asset($pdf->file_name) }}"class="btn btn-primary">
                                    Download
                                </a>
                            </td>
                            <td>{{ $pdf->file_original_name }}</td>
                            <td>{{ $pdf->id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>