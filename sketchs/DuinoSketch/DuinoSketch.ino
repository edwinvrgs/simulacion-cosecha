const int digital_in[3] = {2, 3, 4};
const int din_count = 3;

const int analog_in[3] = {A1, A2, A3};
const int ain_count = 3;

const int digital_out[5] = {5, 7, 9, 11, 12};
const int dout_count = 5;

void setup() {
  Serial.begin(115200);

  //Entrada digital
  for (int i = 0; i < din_count; i++) {
    pinMode(digital_in[i], INPUT_PULLUP);
  }

  //Entrada analógica
  for (int i = 0; i < ain_count; i++) {
    pinMode(analog_in[i], INPUT);
  }

  //Salida digital
  for (int i = 0; i < dout_count; i++) {
    pinMode(digital_out[i], OUTPUT);
    digitalWrite(digital_out[i], LOW);
  }
}

void loop() {

  //Buffer de datos
  int data = 0;

  //Entrada digital
  for (int i = 0; i < din_count; i++) {
   data = digitalRead(digital_in[i]);
   Serial.println(data);

   while(Serial.parseInt() != data){}
  }

  //Entrada analogica
  for (int i = 0; i < ain_count; i++) {
   data = analogRead(analog_in[i]);
   Serial.println(data);

   while(Serial.parseInt() != data){}
  }

  //Salida digital
  for (int i = 0; i < dout_count; i++) {
   data = Serial.parseInt();
   digitalWrite(digital_out[i], data);

   Serial.println(data);
  }
}
