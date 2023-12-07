fn main() {
    let input = std::fs::read_to_string("input.txt").unwrap();
    let mut key = 1;
    let mut valid_games: Vec<i32> = Vec::new();
    for line in input.lines() {
        let pattern = format!("Game {}: ", key);
        let line = line.replacen(&pattern, "", 1);
        let sections = line.split(';').collect::<Vec<&str>>();
        let mut is_valid = true;
        for section in sections {
            let colors = section.split(',').collect::<Vec<&str>>();
            for color in colors {
                let values = color.trim().split(' ').collect::<Vec<&str>>();
                let count = values[0];
                let color = values[1];
                if color == "red" && count.parse::<i32>().unwrap() > 12 {
                    is_valid = false;
                    break;
                } else if color == "green" && count.parse::<i32>().unwrap() > 13 {
                    is_valid = false;
                    break;
                } else if color == "blue" && count.parse::<i32>().unwrap() > 14 {
                    is_valid = false;
                    break;
                }
            } 
        }
        if is_valid {
            valid_games.push(key);
        }
        key += 1;
    }
    println!("Valid games: {:?}", valid_games);
    //print the sum of the valid games
    println!("Sum of valid games: {}", valid_games.iter().sum::<i32>());

}
