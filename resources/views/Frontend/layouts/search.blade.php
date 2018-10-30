<div class="serach_subheader">
    <div class="container">
        <div class="serach_subheader-content">
            {!! Form::open() !!}
            <aside class="serach_subheader-department">
                @isset($main_categories)
                    @foreach($main_categories as $main_category)
                        <input type="button" class="department_button" value="{{ $main_category->{'category_name_'.LaravelLocalization::getCurrentLocale()} }}">
                    @endforeach
                @endisset
            </aside>
            <aside class="serach_subheader-searsh">
                <button type="submit" class="fas fa-search"></button>
                <input type="text" placeholder="بحث">
                <div class="serach_subheader-select">
                    <select>
                        <option> دكتور</option>
                        <option> دكتور</option>
                        <option> دكتور</option>
                    </select>
                    <select>
                        <option> دكتور</option>
                        <option> دكتور</option>
                        <option> دكتور</option>
                    </select>
                </div>
            </aside>
            {!! Form::close() !!}
        </div>
    </div>
</div>
