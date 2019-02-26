//生成数独游戏
const Generator = require("./generator");

//1:生成完成的解决方案:Generator
//2:随机去除部分数据:按比例

module.exports = class Sudoku{
    constructor(){
        //生成完成的解决方案
        const generator = new Generator();
        generator.generate();
        this.solutionMatrix=generator.matrix;
    }
    //level难度,level = 5随机去掉4个数中档难度
    make(level = 4){
        //const shouldRid = Math.random() * 9 < level;
        //生成迷盘
        this.puzzleMatrix = this.solutionMatrix.map(row=>{
            return row.map(cell => Math.random() * 9 < level ? 0 : cell);
        });
    }

}












































