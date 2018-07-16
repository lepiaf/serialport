int remainingCount = 9;

void setup() {
  Serial.begin(9600);
  Serial.print(F("READY;"));
}

void loop()
{
  if (remainingCount > 0) {
    delay(10);
    printState();
    remainingCount--;

    return;
  }

  if (remainingCount == 0) {
    flushSerial();
    delay(25);
    Serial.print(F("READY;"));

    return;
  }
  
  readSerial();
}

void printState()
{
  Serial.print(remainingCount);
  Serial.print(';');
}

void readSerial()
{
  while (Serial.available() > 0) {
    char character = Serial.read();
    if (character != '\n') {
      incomingData[count] = character;
      count++;
    } else {
      Serial.print(F("ACK;"));
      remainingCount = atoi(&incomingData[0]);
    }
  }
}

void flushSerial()
{
  while (Serial.available()) {
    Serial.read();
  }
}
