import { Component } from '@angular/core';
import { Storage } from '@ionic/storage-angular';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  constructor(private storage:Storage) {
    this.storage.create();
  }

  ngOnInit(){
    this.sync();
  }

  varlist = [[]];
  txt: string = "";
  prc: string = "";
  total:number = null;
  aux: number = 0;


  sync(){
    this.varlist = [];
    this.total = 0
    this.storage.forEach((v,k,i)=>{
      this.varlist.push([k,v]);
      this.aux = parseInt(k);
      (this.total += parseFloat(v[1])).toFixed(2);
    })
  }

  sub(v){
    this.total -= parseInt(v.toFixed(2));
  }

  sum(v){
    this.total += parseInt(v.toFixed(2));
  }


  async add(p:string){
    if ((!(this.txt == "")) && (!isNaN(parseInt(this.prc)))) {
      this.varlist.forEach(i=> {
        if(parseInt(i[0])>this.aux){
          this.aux = i[0]
        }
      })

      this.aux += 1;

      await this.storage.set(this.aux.toString(),[this.txt, this.prc]);
      this.sum(parseFloat(p));
      this.sync();

      this.txt = "";
      this.prc = null;
    }
  }

  async rem(i,p){
    await this.storage.remove(i.toString());
    this.sub(parseFloat(p));
    this.sync();
  }

}
