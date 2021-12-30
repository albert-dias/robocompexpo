// Import de pacotes
import React, { useCallback, useEffect, useState } from 'react';
import { Image, ImageBackground, StyleSheet, Text, TouchableOpacity, View } from 'react-native';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';
import { LinearGradient } from 'expo-linear-gradient';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/native';
import { Dialog, Portal } from 'react-native-paper';
import { TextInputMask } from 'react-native-masked-text';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import api from '../../services/api';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function SearchServices({ navigation }: StackScreenProps<ParamListBase>) {

    const [services, setServices] = useState([]);
    const [edit, setEdit] = useState(false);
    const [value, setValue] = useState('');
    const [ID, setID] = useState('');

    const allCategory = async () => {
        try {
            const response = await api.get('user/subcategory');
            setServices(response.data);
        } catch (e) { console.log(e.response.data.message); }
    }

    const editCategory = useCallback(async (id) => {
        try {
            const response = await api.put('user/subcategory', {
                subcategoryUser_id: id,
                price: value.replace(',', '.').replace('R$', '')
            });

            allCategory();
            setEdit(false);

        } catch (e) { console.log(e.response.data.message); }
    }, [ID, value]);

    useEffect(() => {
        allCategory();
        setEdit(false);
    }, []);

    function handleUpdate(id) {
        const serv = services.filter((s) => s.id === id);
        setValue(serv[0].price)
        setID(id);
        setEdit(true);
    }

    return (
        <>
            <View style={{ flexGrow: 1 }}>
                <ScrollView style={styles.scrollView}>
                    <ContainerTop>
                        <ImageBackground
                            source={imgBanner}
                            style={{
                                width: '100%',
                                justifyContent: 'center',
                                alignItems: 'center',
                            }}>
                            <Container pb
                                style={{
                                    flexDirection: 'column',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    width: '100%',
                                }}>
                                <Image
                                    source={logo}
                                    resizeMode="contain"
                                    style={{
                                        width: 200,
                                        height: 200,
                                        marginTop: -30,
                                        marginBottom: -50,
                                    }}
                                />
                                <TouchableOpacity
                                    onPress={() => navigation.goBack()}
                                    style={{
                                        position: 'absolute',
                                        alignSelf: 'flex-start',
                                        marginLeft: '5%',
                                        alignContent: 'flex-start',
                                        alignItems: 'flex-start',
                                    }}>
                                    <FontAwesome5
                                        name='chevron-left'
                                        color={theme.colors.white}
                                        size={40}
                                    />
                                </TouchableOpacity>
                                <Text style={styles.textStyleF}>
                                    RoboComp - Seus Serviços
                                </Text>
                            </Container>
                        </ImageBackground>
                    </ContainerTop>
                    <ScrollView style={styles.scrollView}>
                        {/* Anúncio 1 */}
                        <View style={styles.viewn}>
                            {(services.length > 0) ?
                                (services.map(serv => (
                                    <TouchableOpacity
                                        key={serv.id}
                                        style={styles.anuncioCard}
                                        onPress={() => handleUpdate(serv.id)}
                                    >
                                        <View style={styles.imageInfo}>
                                            <Image
                                                source={{ uri: serv.subcategory.category.icon_url }}
                                                style={{ width: '100%', height: '100%' }}
                                                resizeMode='contain'
                                            />
                                        </View>
                                        <View style={styles.anuncioInfo}>
                                            <View style={{ flexDirection: 'row' }}>
                                                {/* Título do anúncio na tabela */}
                                                <Text style={styles.adTitle}>{serv.subcategory.name}</Text>
                                            </View>
                                            <Text style={styles.adPrice}>R$ {serv.price}</Text>

                                            <Text style={styles.adDescription}>{serv.subcategory.description}</Text>
                                        </View>
                                    </TouchableOpacity>
                                )))
                                : <View />}
                            <Portal>
                                <Dialog
                                    visible={edit}
                                    onDismiss={() => setEdit(false)}
                                    style={styles.dialog}
                                >
                                    <Dialog.Title style={{ marginLeft: 0 }}>
                                        EDITAR ANÚNCIO:
                                    </Dialog.Title>
                                    <View style={{ flexDirection: 'row', alignItems: 'center' }}>
                                        <Text>Preço:</Text>
                                        <TextInputMask
                                            style={styles.inputMask}
                                            type='money'
                                            options={{
                                                precision: 2,
                                                separator: ',',
                                                delimiter: '.',
                                                unit: 'R$',
                                                suffixUnit: ''
                                            }}
                                            value={value}
                                            editable={true}
                                            onChangeText={v => setValue(v)}
                                        />
                                    </View>
                                    <View>
                                        <TouchableOpacity
                                            activeOpacity={0.7}
                                            onPress={() => { editCategory(ID) }}>
                                            <LinearGradient
                                                colors={theme.colors.gradientInvert}
                                                start={{ x: 0.0, y: 1.0 }}
                                                end={{ x: 1.0, y: 1.0 }}
                                                style={styles.submit}>
                                                <Text style={{ fontSize: 20, fontWeight: 'bold', color: theme.colors.whitepure }}>Editar</Text>
                                            </LinearGradient>
                                        </TouchableOpacity>
                                    </View>
                                </Dialog>
                            </Portal>
                        </View>
                    </ScrollView>
                </ScrollView>
            </View>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        flexGrow: 1,
        backgroundColor: '#F4F1F0',
        marginBottom: 'auto',
    },
    submit: {
        width: '50%',
        top: '10%',
        paddingVertical: 16,
        backgroundColor: '#529169',
        borderRadius: 20,
        borderWidth: 1,
        borderColor: '#fff',
        alignItems: 'center',
        alignSelf: 'center',
    },
    textStyle: {
        fontSize: 20,
        fontFamily: 'Manjari-Bold',
        color: 'white',
        textAlign: 'center',
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },

    viewn: {
        marginTop: '7%',
        height: 'auto',
        justifyContent: 'space-around',
    },
    anuncioInfo: {
        maxWidth: '70%',
        marginTop: 10,
    },
    anuncioCard: {
        flexDirection: 'row',
        height: 160,
        marginLeft: '5%',
        marginRight: '5%',
        marginBottom: 20,
        borderRadius: 8,
        backgroundColor: '#FFF',
    },

    imageInfo: {
        width: '30%',
        height: '95%',
        backgroundColor: '#F6F6F6',
        margin: '1%',
        borderRadius: 8,
    },
    imageCard: {
        width: '100%',
        height: '100%',
        borderRadius: 8,
    },
    deleteIcon: {
        alignSelf: 'flex-start',
        marginRight: '2%',
        marginTop: '2%',
    },
    editIcon: {
        alignSelf: 'flex-start',
        marginRight: '2%',
        marginLeft: 'auto',
        marginTop: '2%',
        marginBottom: 'auto',
    },
    adTitle: {
        fontWeight: 'bold',
        marginLeft: 10,
        marginTop: 5,
    },
    adPrice: {
        fontWeight: 'bold',
        marginLeft: 10,
    },
    adDescription: {
        textAlign: 'justify',
        marginLeft: 10,
    },
    dialog: {
        paddingHorizontal: '5%',
        paddingVertical: '5%',
        borderRadius: 20,
    },
    inputMask: {
        marginLeft: '3%',
        marginVertical: '3%',
        width: '25%',
        height: 40,
        borderWidth: 1,
        borderColor: theme.colors.black,
        backgroundColor: '#fff',
        alignItems: 'center',
        textAlign: 'center',
    },

});