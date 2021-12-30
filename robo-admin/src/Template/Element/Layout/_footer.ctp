    <!-- Footer -->
    <?php if(!$this->request->is('mobile')){?>
    <script>
        $(document).ready(function (e) {
            $("select[name='categories[]']").mousedown(function(e){
            e.preventDefault();
            
                var select = this;
            var scroll = select.scrollTop;
            
            e.target.selected = !e.target.selected;
            
            setTimeout(function(){select.scrollTop = scroll;}, 0);
            
            $(select).focus();
        }).mousemove(function(e){e.preventDefault()});
        })
    </script>
    <?php }?>
    <footer class="footer">
        © 2021 Robocomp <span class="d-none d-sm-inline-block"> - grupoecomp.robocomp.com.br - Desenvolvido por Corps Teknologi</span>
    </footer>