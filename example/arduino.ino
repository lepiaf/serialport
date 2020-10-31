int remainingCount = 9;
char incomingData[30];
bool awaitUserInput = false;
int serialCharCount = 0;

void setup() {
  Serial.begin(115200);
  Serial.print(F("READY"));
  Serial.print('\n');
}

void loop()
{
  if (remainingCount > 0) {
    delay(100);
    printState();
    remainingCount--;

    return;
  }

  if (remainingCount == 0 && awaitUserInput == false) {
    flushSerial();
    delay(100);
    Serial.print(F("END COUNT"));
    Serial.print('\n');

    serialCharCount = 0;
    awaitUserInput = true;
  }

  readSerial();
}

void printState()
{
  Serial.print(remainingCount);
  Serial.print('\n');
}

void readSerial()
{
  while (Serial.available() > 0) {
    char character = Serial.read();
    if (character != '\n') {
      incomingData[serialCharCount] = character;
      serialCharCount++;
    } else {
      Serial.print(F("ACK"));
      Serial.print('\n');
      remainingCount = atoi(&incomingData[0]);
      awaitUserInput = false;
    }
  }
}

void flushSerial()
{
  while (Serial.available()) {
    Serial.read();
  }
}
