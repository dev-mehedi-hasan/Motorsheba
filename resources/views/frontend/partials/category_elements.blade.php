<div class="card-columns">
    @php
    $seller_user = \App\User::where('user_type', 'seller')->where('name', 'LIKE', '%RT Fronuse%')->first(); 
    @endphp
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
        <div class="card shadow-none border-0">
            <ul class="list-unstyled mb-3">
                <li class="fw-600 border-bottom pb-2 mb-3">
                    @php
                        $category_levelone = \App\Category::find($first_level_id);
                    @endphp
                    <a class="text-reset" href="{{ route('products.subcategory.seller', ['category_id'=>$category_levelone->parent_id,'subcategory_slug' => $category_levelone->slug,'seller_user_id'=>$seller_user->id]) }}">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</a>
                </li>
                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                    <li class="mb-2">
                        @php
                            $category_leveltwo = \App\Category::find($second_level_id);
                        @endphp
                        <a class="text-reset" href="{{ route('products.subcategory.seller', ['category_id'=>$category_leveltwo->parent_id,'subcategory_slug' => $category_leveltwo->slug,'seller_user_id'=>$seller_user->id]) }}">{{ \App\Category::find($second_level_id)->getTranslation('name') }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
