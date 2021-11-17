@extends('frontend.layouts.user_panel')

@section('panel_content')
@php
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp
    <div class="card">
        <form id="sort_orders" action="" method="GET">
          <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
              <h5 class="mb-md-0 h6">{{ translate('Orders') }}</h5>
            </div>
          </div>
        </form>

        @if (count($orders) > 0)
            <div class="card-body p-3">
                <table id="default_order" class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Order Code')}}</th>
                            <th data-breakpoints="lg">{{ translate('Num. of Products')}}</th>
                            <th data-breakpoints="lg">{{ translate('Product Code')}}</th>
                            <th data-breakpoints="lg">{{ translate('Customer')}}</th>
                            <th data-breakpoints="md">{{ translate('Amount')}}</th>
                            <th data-breakpoints="lg">{{ translate('Delivery Status')}}</th>
                            <th>{{ translate('Payment Status')}}</th>
                            @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                            <th>{{ translate('Refund') }}</th>
                            @endif
                            <th class="text-right">{{ translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order_id)
                            @php
                                $order = \App\Order::find($order_id->id);
                            @endphp
                            @if($order != null)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        <a href="#{{ $order->code }}" onclick="show_order_details({{ $order->id }})">{{ $order->code }}</a>
                                    </td>
                                    <td>
                                        {{ count($order->orderDetails->where('seller_id', Auth::user()->id)) }}
                                    </td>
                                    <td>
                                        @foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $product)
                                        <ul class="m-0 list-unstyled">
                                            @foreach ($product->product->stocks as $item)
                                                <li class="">
                                                    <a href="{{ route('product', $item->product->slug) }}" target="_blank" class="text-reset text-primary">{{$item->sku}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($order->user_id != null)
                                            {{ $order->user->name }}
                                        @else
                                            Guest ({{ $order->guest_id }})
                                        @endif
                                    </td>
                                    <td>
                                        {{ single_price($order->grand_total) }}
                                    </td>
                                    <td>
                                        @php
                                            $status = $order->orderDetails->first()->delivery_status;
                                        @endphp
                                        {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                                    </td>
                                    <td>
                                        @if ($order->orderDetails->where('seller_id', Auth::user()->id)->first()->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success">{{ translate('Paid')}}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{ translate('Unpaid')}}</span>
                                        @endif
                                    </td>
                                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                    <td>
                                        @if (count($order->refund_requests) > 0)
                                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                        @else
                                        {{ translate('No Refund') }}
                                        @endif
                                    </td>
                                    @endif
                                    <td class="text-right">
                                        <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="show_order_details({{ $order->id }})" title="{{ translate('Order Details') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-soft-warning btn-icon btn-circle btn-sm" title="{{ translate('Download Invoice') }}">
                                            <i class="las la-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $orders->links() }}
              	</div>
            </div>
        @endif
    </div>

@endsection

@section('modal')
    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el){
            $('#sort_orders').submit();
        }
    </script>
@endsection
