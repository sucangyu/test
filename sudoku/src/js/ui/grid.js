//生成九宫格
const Toolkit = require("../core/toolkit");
const Generator = require("../core/generator");

class Grid{
    constructor(container){
        this._$container = container;
    }

    build(){
        const generator = new Generator();
        generator.generate();
        // const matrix = Toolkit.matrix.makeMatrix();
        const matrix = generator.matrix;

        const rowGroupClasses = ["row_g_top","row_g_middle","row_g_bottom"];
        const colGroupClasses = ["col_g_left","col_g_center","col_g_right"];

        const $cells = matrix.map(rowValues => rowValues
            .map((cellValue,colIndex) => {
            return $("<span>")
                .addClass(colGroupClasses[colIndex % 3])
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
    //span样式
    layout(){
        const width = $("span:first",this._$container).width();
        $("span",this._$container)
            .height(width)
            .css({
                "line-height": `${width}px`,
                "font-size": width < 32 ? `${width / 2}px` : ""
            });
    }
}

module.exports = Grid;














