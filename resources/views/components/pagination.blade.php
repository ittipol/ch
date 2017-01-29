@if(!empty($pagination))
<div class="row">
  <div class="col-xs-12 pagination clearfix">
    <div class="pagination-inner clearfix">

      @if(!empty($pagination['prev']['url'])) 
        <a href="{{$pagination['prev']['url']}}" class="paging icon icon-prev"></a>
      @endif

      @foreach($pagination['paging'] as $paging)

        @if(!empty($paging['url']))
          <a href="{{$paging['url']}}" class="paging @if($paging['pageNumber'] == $pagination['page']) selected @endif">
            {{$paging['pageNumber']}}
          </a>
        @else
          <span class="paging">
            {{$paging['pageNumber']}}
          </span>
        @endif

        
      @endforeach

      @if(!empty($pagination['next']['url'])) 
        <a href="{{$pagination['next']['url']}}" class="paging icon icon-next"></a>
      @endif
    
    </div>
  </div>
</div>
@endif