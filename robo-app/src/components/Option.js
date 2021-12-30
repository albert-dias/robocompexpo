import React, { useState } from 'react';
import { TouchableOpacity, Image, StyleSheet, Text } from 'react-native';
import GlobalContext from 'src/context';

const {
    cadastro: { categoryIdsRef },
} = GlobalContext;

const Option = props => {
    const { initiallySelected, value, urlIcon, name } = props;
    const [isSelected, setSelected] = useState(initiallySelected);

    const categoryIds = useStateLink(categoryIdsRef);

    return (
        <TouchableOpacity
            onPress={() => {
                setSelected(!isSelected);
                if (categoryIds.value.includes(value)) {
                    categoryIds.set(
                        categoryIds.value.filter(function (x, index, arr) {
                            return x != value;
                        }),
                    );
                } else {
                    categoryIds.set(categoryIds.value.concat([value]));
                }
            }}>
            <Image
                style={[styles.icon, isSelected ? styles.active : styles.inactive]}
                source={{
                    uri: urlIcon,
                }}
            />
            <Text style={styles.iconText}>{name}</Text>
        </TouchableOpacity>
    );
};

const styles = StyleSheet.create({
    icon: {
        width: 70,
        height: 70,
        marginVertical: 10,
        marginLeft: 3,
        borderRadius: 50,
    },
    active: {
        opacity: 0.7,
        borderWidth: 3,
        borderColor: 'green',
    },
    inactive: {
        borderWidth: 3,
        borderColor: 'transparent',
    },
    iconText: {
        textAlign: 'center',
        flexWrap: 'wrap',
        width: 75,
    },
});

export default Option;
