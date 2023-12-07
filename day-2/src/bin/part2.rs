fn main() {
    let input = std::fs::read_to_string("input.txt").unwrap();
    let mut key = 1;
    let mut powers: Vec<i32> = Vec::new();
    for line in input.lines() {
        let pattern = format!("Game {}: ", key);
        let line = line.replacen(&pattern, "", 1);
        let sections = line.split(';').collect::<Vec<&str>>();
        let mut red = 0;
        let mut green = 0;
        let mut blue = 0;
        for section in sections {
            let colors = section.split(',').collect::<Vec<&str>>();
            for color in colors {
                let values = color.trim().split(' ').collect::<Vec<&str>>();
                let count = values[0];
                let count = count.parse::<i32>().unwrap();
                let color = values[1];
                if color == "red" && count > red {
                    red = count;
                } else if color == "green" && count > green {
                    green = count;
                } else if color == "blue" && count > blue {
                    blue = count;
                }
            } 
        }
        let power = red * green * blue;
        powers.push(power);
        key += 1;
    }
    println!("Sum of powers: {}", powers.iter().sum::<i32>());

}
