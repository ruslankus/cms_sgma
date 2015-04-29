    <div class="wrap"><div class="middle" id="model">
        <div class="content" id="delete-images" style="">

            <div class="message">Delete Image forbidden</div>
            <div>
            <?php foreach($links as $link):?>
                <?php echo CHtml::link($link,$link)?><br/>
            <?php endforeach;?>
            </div>
            <input type="button" value="Cancel" class="float-left cancel" id="cancel-lightbox"/>

        </div><!--/content delete all selected-->
    </div></div><!--/wrap/middle-->