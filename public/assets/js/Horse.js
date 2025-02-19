export default class Horse {
    constructor(name, minSpeed, maxSpeed, acceleration, endurance) {
        this.name = name;
        this.minSpeed = minSpeed;
        this.maxSpeed = maxSpeed;
        this.acceleration = acceleration;
        this.endurance = endurance;
        this.currentSpeed = minSpeed;
        this.time = 0;
        this.distance = 0;
        this.finished = false;
    }

    updateSpeed() {
        if (this.finished) {
            this.currentSpeed = 0; // Si le cheval a terminé, sa vitesse est 0
        } else if (this.time < this.acceleration) {
            this.currentSpeed = this.minSpeed + (this.maxSpeed - this.minSpeed) * (this.time / this.acceleration);
        } else if (this.time < this.acceleration + this.endurance) {
            this.currentSpeed = this.maxSpeed;
        } else {
            const decelerationTime = this.time - (this.acceleration + this.endurance);
            this.currentSpeed = this.maxSpeed - (this.maxSpeed - this.minSpeed) * (decelerationTime / this.endurance);
            // on s'assure que la vitesse ne descend pas en dessous de minSpeed
            if (this.currentSpeed < this.minSpeed) {
                this.currentSpeed = this.minSpeed; 
            }
        }
    }

    move(raceLength) {
        this.updateSpeed();
        this.time++;
        this.distance += this.currentSpeed;
        if (this.distance >= raceLength) {
            this.finished = true; // Marquer le cheval comme ayant terminé la course
            this.distance = raceLength; // S'assurer que le cheval ne dépasse pas la ligne d'arrivée
        }
        return this.currentSpeed;
    }
}