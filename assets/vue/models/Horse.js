export default class Horse {
    constructor(name, image, minSpeed, maxSpeed, acceleration, endurance) {
        this.name = name;
        this.image = image;
        this.minSpeed = minSpeed;
        this.maxSpeed = maxSpeed;
        this.acceleration = acceleration;
        this.endurance = endurance;
        this.currentSpeed = minSpeed;
        this.time = 0;
        this.distance = 0;
    }

    updateSpeed() {
        if (this.time < this.acceleration) {
            this.currentSpeed = this.minSpeed + (this.maxSpeed - this.minSpeed) * (this.time / this.acceleration);
        } else if (this.time < this.acceleration + this.endurance) {
            this.currentSpeed = this.maxSpeed;
        } else {
            const decelerationTime = this.time - (this.acceleration + this.endurance);
            this.currentSpeed = this.maxSpeed - (this.maxSpeed - this.minSpeed) * (decelerationTime / this.endurance);
        }
    }

    move() {
        this.updateSpeed();
        this.time++;
        this.distance += this.currentSpeed;
        return this.currentSpeed;
    }

}