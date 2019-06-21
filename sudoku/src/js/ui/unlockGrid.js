//生成九宫格
const Toolkit = require("../core/toolkit");
const Generator1 = require("../core/generator1");

class unlockGrid{
    constructor(container){
        this._$container = container;
    }
    //解锁版型
    unlockBuild(){

        const matrix = Toolkit.matrix.makeMatrix();//生成完整空盘

        const rowGroupClasses = ["row_g_top","row_g_middle","row_g_bottom"];
        const colGroupClasses = ["col_g_left","col_g_center","col_g_right"];

        const $cells = matrix.map(rowValues => rowValues
            .map((cellValue,colIndex) => {
            return $("<span>")
                .addClass(colGroupClasses[colIndex % 3])
                .addClass(cellValue ? "fixed" : "empty")
                .text(cellValue);
            }));

        const $divArray = $cells.map(($spanArray,rowIndex) => {
            return $("<div>")
                .addClass("row")
                .addClass(rowGroupClasses[rowIndex % 3])
                .append($spanArray);
        });

        this._$container.append($divArray);
    }

    //数独盘数字span样式
    layout(){
        const width = $("span:first",this._$container).width();
        $("span",this._$container)
            .height(width)
            .css({
                "line-height": `${width}px`,
                "font-size": width < 32 ? `${width / 2}px` : ""
            });
    }


    //弹出数字面板
    bindPopup(popupNumbers){
        this._$container.on("click","span",e=>{
            const $cell=$(e.target);
            if (!$cell.hasClass("fixed")) {
                popupNumbers.popup($cell);
            }
        });
    }


    //解锁
    unlock(){
        //获取已填写的盘面信息
        const data = this._$container.children()
            .map((rowIndex,div)=>{
                return $(div).children()
                    .map((colIndex,sapn)=>parseInt($(sapn).text()) || 0);
            })
            .toArray()
            .map($data=>$data.toArray());
        // console.log(data);
        //解密
        const generator1 = new Generator1();
        generator1.internalGenerate(data);
        const start = generator1.start();
        console.log(start);
    }
    //重建刷新
    unRebuild(){
        this._$container.empty();
        this.unlockBuild();
        this.layout();
    }

}

module.exports = unlockGrid;















