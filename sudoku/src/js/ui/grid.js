//生成九宫格
const Toolkit = require("../core/toolkit");
const Generator = require("../core/generator");
const Sudoku = require("../core/sudoku");
const Checker = require("../core/checker");

class Grid{
    constructor(container){
        this._$container = container;
    }

    build(){

        /*const matrix = Toolkit.matrix.makeMatrix();//方法1
        const generator = new Generator();
        generator.generate();
        const matrix = generator.matrix;//生成完整盘*/
        const sudoku = new Sudoku();
        sudoku.make();
        // const matrix = sudoku.solutionMatrix;//完整成盘
        const matrix = sudoku.puzzleMatrix;//生成随机去掉数字的数独盘
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

    //检测用户解密结果,成功提示,失败显示错误位置
    check(){
        //重界面获取要检查的数据
        const data = this._$container.children()
            .map((rowIndex,div)=>{
                return $(div).children()
                    .map((colIndex,sapn)=>parseInt($(sapn).text()) || 0);
            })
            .toArray()
            .map($data=>$data.toArray());
        // console.log(data);
        const checker = new Checker(data);
        if(checker.check()){
            return true;
        }

        //检查不成功进行标记
        const marks = checker.matrixMarks;
        this._$container.children()
            .each((rowIndex,div)=>{
                $(div).children().each((colIndex,span)=>{
                    const $span = $(span);
                    if ($span.is(".fixed") || marks[rowIndex][colIndex]) {
                        //如果是盘底或者数值正确
                        $span.removeClass("error");
                    }else{
                        $span.addClass("error");
                    }
                });
            });

    }
    //重置当前迷盘到初始状态
    reset(){
        this._$container.find("span:not(.fixed)")
            .removeClass("error mark1 mark2")
            .addClass("empty")
            .text(0);
    }
    //清理错误标记
    clear(){
        this._$container.find("span.error")
            .removeClass("error");
    }
    //重建刷新
    rebuild(){
        this._$container.empty();
        this.build();
        this.layout();
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

}

module.exports = Grid;















