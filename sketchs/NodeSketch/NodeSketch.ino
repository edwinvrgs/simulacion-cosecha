#include <ESP8266WiFi.h>
#include <Modbus.h>
#include <ModbusIP_ESP8266.h>

const int in_coils[3] = {500, 501, 502};
const int cin_count = 3;

const int in_hreg[3] = {509, 510, 511};
const int hin_count = 3;

const int out_coils[5] = {503, 504, 505, 506, 507};
const int cout_count = 5;

//ModbusIP object
ModbusIP mb;

void setup() {
  Serial.begin(115200);

  mb.config("Onix", "180196260499");
  while (WiFi.status() != WL_CONNECTED) { delay(250); }
  Serial.println(WiFi.localIP());

  for (int i = 0, j = 0; i < cin_count, j < cout_count; i++, j++) {
    mb.addCoil(in_coils[i]);
    mb.addCoil(out_coils[j]);
  }

  for (int i = 0; i < hin_count; i++) {
    mb.addHreg(in_hreg[i]);
  }
}

void loop() {

   mb.task();
   int data = 0;

   if (Serial.available()) {

     for (int i = 0; i < cin_count; i++) {
       data = Serial.parseInt();
       mb.Coil(in_coils[i], data);

       Serial.println(data);
     }

     for (int i = 0; i < hin_count; i++) {
       data = Serial.parseInt();
       mb.Hreg(in_hreg[i], data);

       Serial.println(data);
     }

     for (int i = 0; i < cout_count; i++) {
       int data = mb.Coil(out_coils[i]);
       Serial.println(data);

       while(Serial.parseInt() != data){}
     }
   }
}
