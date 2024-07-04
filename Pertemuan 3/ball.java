package ball;
/**
 *
 * @author U53R
 */
public class Ball {
    private float x, y, xDelta, yDelta;
    private int radius;
    
    public Ball(float x, float y, float xDelta, float yDelta, int radius) {
        this.x = x;
        this.y = y;
        this.xDelta = xDelta;
        this.yDelta = yDelta;
        this.radius = radius;
    }

    public float getX() {
        return x;
    }

    public void setX(float x) {
        this.x = x;
    }

    public float getY() {
        return y;
    }

    public void setY(float y) {
        this.y = y;
    }

    public float getxDelta() {
        return xDelta;
    }

    public void setxDelta(float xDelta) {
        this.xDelta = xDelta;
    }

    public float getyDelta() {
        return yDelta;
    }

    public void setyDelta(float yDelta) {
        this.yDelta = yDelta;
    }

    public int getRadius() {
        return radius;
    }

    public void setRadius(int radius) {
        this.radius = radius;
    }
    
    public void move(){
        x += xDelta;
        y += yDelta;
    }
    
    public void reflectHorizontal(){
        xDelta = -xDelta;
    }
    
    public void reflectVertical(){
        yDelta = -yDelta;
    }
    
    public String toString(){
        return("Ball[("+x+","+y+"),speed=("+xDelta+","+yDelta+")]");
    } 
}