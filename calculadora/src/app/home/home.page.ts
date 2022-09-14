import { Component } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  constructor() {}

  visor: string = "0";
  mem: string = "";
  t1: string = "";
  t2: string = "";
  op_act: Boolean = false;
  op_sel: string = "";
  done: Boolean = false;

  digito(v) {
    if (this.op_act == false) {
      if (this.done == true) {
        this.done = false;
        this.cls();
      }
      if (this.visor == "0") {
        this.visor = v;
      }
      else {
        this.visor = this.visor + v;
      }
    }
    else {
      this.visor = this.visor + v;
      this.t2 = this.t2 + v;
    }
       
    console.log("termo 1:", this.t1);
    console.log("termo 2:", this.t2);
  }

  cls() {
    this.visor = "0";
    this.op_act = false;
    this.t1 = "";
    this.t2 = "";
  }

  op(o) {
    this.t1 = this.visor;
    this.visor = this.visor + o;
    this.op_act = true;
    this.op_sel = o;
    if (o == "+") {
     
    }
   
    if (o == "-") {
     
    }

   
    if (o == "*") {
     
    }

   
    if (o == "/") {
     
    }

  }

  calc() {
    let termo1 = parseInt(this.t1);
    let termo2 = parseInt(this.t2);

    this.mem = this.visor;

    if (this.op_sel == "+") {
      this.visor = (termo1 + termo2).toString();
    }
   
    if (this.op_sel == "-") {
      this.visor = (termo1 - termo2).toString();
    }
   
    if (this.op_sel == "x") {
      this.visor = (termo1 * termo2).toString();
    }
   
    if (this.op_sel == "/") {
      this.visor = (termo1 / termo2).toString();
    }

    this.op_act = false;
    this.done = true;

    this.mem = this.mem + "=" + this.visor;

  }

}