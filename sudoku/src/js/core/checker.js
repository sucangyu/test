//检查数据解决方案

function checkArray(array) {
    const length = array.length;
    const marks = new Array(length);//检查完生成错误标记的数组
    marks.fill(true);//初始化

    for (let i=0;i<length;i++){
        if (!marks[i]){
            continue;//如果已经检查过是false结束
        }

        const v=array[i];
        //1:检查是否有效,0 - 无效,1-9 有效
        if(!v){
            marks[i] = false;
            continue;
        }
        //2:检查是否有重复:i+1--9,是否和i位置的数据重复
        for (let j=i+1;j<length;j++){
            if(v===array[j]){
                marks[i]=marks[j]=false;
            }
        }
    }
    return marks;
}

const Toolkit = require("./toolkit");
/**
 * 输入:matrix,用户完成的数独数据,9*9
 * 处理:对martrix 行 列 宫进行检查,并填写marks
 * 输出:检查是否成功 marks
 */
module.exports = class Checker{
    constructor(matrix){
        this._matrix = matrix;
        this._matrixMarks = Toolkit.matrix.makeMatrix(true);
    }

    get matrixMarks(){
        return this._matrixMarks;
    }
    //二次检查
    get isSuccess(){
        return this._success;
    }

    check(){
        this.checkRows();//检查行
        this.checkCols();//检查列
        this.checkBoxes();//检查宫

        //检查是否成功
        this._success = this._matrixMarks.every(row => row.every(mark => mark));
        return this._success;
    }

    //检查行
    checkRows(){
        for (let rowIndex = 0;rowIndex < 9;rowIndex++){
            const row = this._matrix[rowIndex];
            const marks = checkArray(row);

            for (let colIndex=0;colIndex<marks.length;colIndex++){
                if(!marks[colIndex]){
                    this._matrixMarks[rowIndex][colIndex] = false;//标记这一行这一列为false
                }
            }
        }
    }
    //检查列
    checkCols(){
        //1:生成列数据
        for (let colIndex=0;colIndex<9;colIndex++) {
            const cols = [];
            for (let rowIndex=0;rowIndex<9;rowIndex++){
                cols[rowIndex]=this._matrix[rowIndex][colIndex];
            }
            //进行列检查
            const marks = checkArray(cols);
            for(let rowIndex=0;rowIndex<marks.length;rowIndex++){
                if(!marks[rowIndex]){
                    this._matrixMarks[rowIndex][colIndex]=false;
                }
            }
        }
    }
    //检查宫
    checkBoxes(){
        //1:生成宫数据
        for (let boxIndex=0;boxIndex<9;boxIndex++){
            const boxes=Toolkit.box.getBoxCells(this._matrix,boxIndex);
            const marks=checkArray(boxes);
            //1.2:进行坐标转换
            for (let cellIndex=0;cellIndex<9;cellIndex++){
                if(!marks[cellIndex]){
                    const { rowIndex,colIndex } = Toolkit.box.convertFromBoxIndex(boxIndex,cellIndex);
                    this.matrixMarks[rowIndex][colIndex] =  false;
                }
            }
        }
    }
}

/*//验证
const Generator = require("./generator");
const gen = new Generator();
gen.generate();
const matrix = gen.matrix;

const checker = new Checker(matrix);
console.log("check result", checker.check());
console.log(checker.matrixMarks);

matrix[1][1]=0;
matrix[2][3]=matrix[3][5]=5;
const checker2 = new Checker(matrix);
console.log("check result", checker2.check());
console.log(checker2.matrixMarks);*/

















































