//生成数独解决方案
const Toolkit = require("./toolkit");

module.exports = class Generator{
    generate(){
        while (!this.internalGenerate()){
            //尝试的次数显示
            console.warn("try again");
        }
    }
    internalGenerate(){
        //TODD 入口方法
        this.matrix = Toolkit.matrix.makeMatrix();
        this.orders = Toolkit.matrix.makeMatrix()
            .map(row=>row.map((v,i)=>i))
            .map(row=>Toolkit.matrix.shuffle(row));//生成随机矩阵

        for (let n =1;n<=9;n++){
            if (!this.fillNumber(n)){
                return false;
            }
        }
        return true;
    }

    fillNumber(n){
        return this.fillRow(n,0);
    }

    fillRow(n,rowIndex){
        if (rowIndex>8){
            return true;//成功结束
        }

        const row = this.matrix[rowIndex];
        //TODD 随机选择列
        const orders = this.orders[rowIndex];
        for (let i = 0;i < 9;i++) {
            const  colIndex = orders[i];
            //如果这个位置已经优质,跳过
            if(row[colIndex]){
                continue;
            }
            //检查这个位置是否可以填 n
            if(!Toolkit.matrix.checkFillable(this.matrix,n,rowIndex,colIndex)){
                continue;
            }
            row[colIndex] = n;
            //当前行填写 n 成功,递归调用fillRow() 来在下一行中填写n
            //去下一行填写n,如果没填写,就继续寻找当前行下一个位置
            if(!this.fillRow(n,rowIndex+1)){
                row[colIndex] = 0;
                continue;
            }

            return true;//填写成功
        }

        return false;//填写失败
    }
};

/*const generator = new Generator();
generator.generate();
console.log(generator.matrix)*/



















