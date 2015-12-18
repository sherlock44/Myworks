<?
class ajaxpager

{
    /**
     * 数据表中符合查询条件的记录总数
     * @var int
     */
    var $TotalCount = -1;
    /**
     * 每页记录数
     *
     * @var int
     */
    var $PageSize = -1;
     /**
     * 控制记录条的个数。
     *
     * @var int
     */
    var $PagebarNumber = 10;
    /**
     * 分页总数
     * @var int
     */

    var $PageCount = -1;

    /**
     * 记录条的个数的最小值
     *
     * @var int
     */

    var $MinPageNumber = -1;


   /**
     * 上一页的页码
     *
     * @var int
     */

    var $PrevPageNumber = -1;
    /**
     * 下一页的页码
     *
     * @var int
     */

    var $NextPageNumber = -1;

    /**
     * 当前页的索引
     *
     * @var int
     */

    var $CurrentPage = -1;

    /**
     * url地址头
     *
     * @var int
     */

    var $Url = '';

    /**
    *跳转后显示的位置
    */

    var $Weizhi='';



    function ajaxpager($TotalCount,$CurrentPage,$PageSize,$PagebarNumber,$Url,$Weizhi=''){

        $this->TotalCount    = $TotalCount;

        $this->PageSize      = $PageSize;

        $this->CurrentPage   = $CurrentPage;

        $this->PagebarNumber = 4;

        $this->Url           = $Url;

        $this->Weizhi        =$Weizhi;

        $this->computingPage();

    }

    /**
     * 计算各项分页参数
     */

    function computingPage()
    {
        $this->PageCount = ceil($this->TotalCount / $this->PageSize);
        // 计算当前所在的记录个数的最小值
        if($this->CurrentPage < $this->PagebarNumber){
            $this->MinPageNumber =1;
        }else{
             $this->MinPageNumber = $this->CurrentPage-ceil(($this->CurrentPage % $this->PagebarNumber));
        }
        // 上一页
        if($this->CurrentPage > 1){
            $this->PrevPage = $this->CurrentPage - 1;
            if($this->CurrentPage>$this->PageCount){
                $this->CurrentPage=$this->PageCount;
            }
        }else{
            $this->CurrentPage=1;
            $this->PrevPage = 1;
        }
        // 下一页

        if($this->CurrentPage < $this->PageCount ) {
            $this->NextPage = $this->CurrentPage + 1;
        }else{
            $this->NextPage = $this->CurrentPage;
        }
    }


    function Ajax_Print($FunctionName)

    {

        $Html  = "<a href='javascript:void(0)' onclick='".$FunctionName."(1)'>  首页 </a> ";

        $Html .= "<a href='javascript:void(0)' onclick='".$FunctionName."(".$this->PrevPage.")'> <  上一页 </a> ";
        $MaxPageNumber = $this->MinPageNumber+$this->PagebarNumber;

        if ($MaxPageNumber > $this->PageCount){

            $MaxPageNumber = $this->PageCount;

        }

        for($i=$this->MinPageNumber; $i <= $MaxPageNumber; $i++)

        {

            if($i == $this->CurrentPage)

                $Html .= " <span class='current'>$i</span>";

            else

                $Html .= " <a href= 'javascript:void(0)' onclick='".$FunctionName."(".$i.")'>$i</a> ";

        }

        $Html .= " <a href= 'javascript:void(0)' onclick='".$FunctionName."(".$this->NextPage.")'> 下一页  > </a>

                  <a href= 'javascript:void(0)' onclick='".$FunctionName."(".$this->PageCount.")'> 尾页 </a>";
       return $Html;

    }

    function Fen_Print($FunctionName)
    {
        $Html  = "共有: ".$this->TotalCount." 条记录 ";
        $Html .= "<a href='javascript:void(0)'   onclick='".$FunctionName."(".$this->PrevPage.")'> <  上一页 </a> ";
        $MaxPageNumber = $this->MinPageNumber+$this->PagebarNumber;
        if ($MaxPageNumber > $this->PageCount){
            $MaxPageNumber = $this->PageCount;
        }
        for($i=$this->MinPageNumber; $i <= $MaxPageNumber; $i++)

        {
            if($i == $this->CurrentPage)

                $Html .= $i;
            else
                $Html .= " <a href= 'javascript:void(0)' onclick='".$FunctionName."(".$i.")'>$i</a> ";

        }

        $Html .= " <a href= 'javascript:void(0)' onclick='".$FunctionName."(".$this->NextPage.")'> 下一页  > </a> ";
        return $Html;

    }

}
?>