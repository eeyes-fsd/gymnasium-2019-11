import configparser as config
import scipy.optimize as opt
import redis
import json
import sys

ACCURACY = 0.01


def solve(coefficients, constraints, lower_bounds):
    dimension = len(coefficients[0])
    f = [1 for i in range(dimension)]

    a = coefficients
    for i in range(3):
        temp = map(lambda x: -x, coefficients[i])
        a.append(list(temp))

    b = list(map(lambda x: x * (1 + ACCURACY), constraints))
    b += list(map(lambda x: -x * (1 - ACCURACY), constraints))

    bounds = []
    for lb in lower_bounds:
        bounds.append((lb, None))

    result = opt.linprog(f, a, b, bounds=bounds)
    return result


def main():
    # a = [
    #     # 鸡脯肉 玉米粒  小香芹  面  粉  橄榄油
    #     [0.100, 0.912, 0.124, 2.836, 0.000],  # 碳水化合物
    #     [0.776, 0.160, 0.016, 0.628, 0.000],  # 蛋白质
    #     [0.450, 0.108, 0.018, 0.225, 8.991],  # 脂肪
    # ]
    #
    # b = [150, 75, 75]
    #
    # lb = [50, 10, 10, 40, 1]
    #
    # result = solve(a, b, lb)
    # exit()

    argv = sys.argv

    redis_config = config.ConfigParser()
    redis_config.read('.env')

    redis_connection = redis.Redis(
        redis_config.get('redis', 'host'),
        redis_config.get('redis', 'port'),
        # redis_config.get('redis', 'password'),
        redis_config.get('redis', 'db'),
        decode_responses=True,
    )

    key = redis_config.get('app', 'name') + ':' + redis_config.get('app', 'tag') + ':' + argv[1]
    data = redis_connection.get(key)
    data = json.loads(data)

    result = solve(data['a'], data['b'], data['lb'])
    redis_connection.set(key, json.dumps(result.x))

    redis_connection.close()


if __name__ == '__main__':
    main()
