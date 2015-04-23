<?php
/**************************************************** P A G E S *******************************************************/
class ComplexController extends ControllerAdmin
{
    public function actionPages($page = 1)
    {
        $this->renderText('Under construction...');
    }

    /******************************** A T T R I B U T E S : G R O U P S ***********************************************/

    /**
     * List all groups
     * @param int $page
     */
    public function actionAttrGroups($page = 1)
    {
        $this->renderText('Under construction...');
    }

    /******************************** A T T R I B U T E S : F I E L D S ***********************************************/

    /**
     * List all fields of specified group
     * @param int $page
     * @param $group
     */
    public function actionFields($page = 1, $group = 0)
    {
        $this->renderText('Under construction...');
    }
}
