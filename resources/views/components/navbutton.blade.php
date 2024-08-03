<div class="headerbar-item pull-right visible-lg">
        @php 
            //dump( $totItem);
            $limit = 25;

            $page = $_GET['page'] ?? 0;
            $prevPage=$page - 1; if($page<0) $page=0;
            $lastPage = ceil($totItem/$limit);
            $nextPage = $page + 1; if($page>$lastPage) $page=$lastPage;
            //dump($lastPage);
        @endphp
        <div class="model-pager btn-group btn-group-sm">
            <a class="btn btn-default " href="http://localhost/lav7_invplane/clients/list?page=0" title="First"><i class="fa fa-fast-backward no-margin"></i></a>
            <a class="btn btn-default " href="http://localhost/lav7_invplane/clients/list?page={{$prevPage}}" title="Prev"><i class="fa fa-backward no-margin"></i></a>
            <a class="btn btn-default " href="http://localhost/lav7_invplane/clients/list?page={{$nextPage}}" title="Next"><i class="fa fa-forward no-margin"></i></a>
            <a class="btn btn-default " href="http://localhost/lav7_invplane/clients/list?page={{$lastPage}}" title="Last"><i class="fa fa-fast-forward no-margin"></i></a>
        </div>    
</div>
