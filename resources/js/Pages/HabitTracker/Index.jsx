import React, { useState } from 'react';
import { Head, router, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function HabitTracker({ auth, routines }) {
    // React state to handle which routine we are currently adding a habit to
    const [activeRoutineId, setActiveRoutineId] = useState(null);

    // Inertia's useForm hook makes handling inputs and validation errors simple
    const { data, setData, post, reset, processing } = useForm({
        name: '',
    });

    // Handle adding a new habit
    const submitHabit = (e, routineId) => {
        e.preventDefault();
        post(route('habits.store', routineId), {
            onSuccess: () => {
                reset('name');
                setActiveRoutineId(null);
            },
        });
    };

    // Handle completing a habit to get the animal badge
    const completeHabit = (habitId) => {
        router.post(route('habits.complete', habitId), {}, {
            preserveScroll: true, // Keeps the user in the same spot on the page
        });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-2xl text-gray-800 leading-tight">Kids Daily Routines</h2>}
        >
            <Head title="Routine Tracker" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                    
                    {/* Map through the routines passed from Laravel */}
                    {routines.map((routine) => (
                        <div key={routine.id} className="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-6 border-t-8 border-indigo-400">
                            <h3 className="text-3xl font-bold text-indigo-600 mb-6">{routine.name}</h3>

                            {/* List of Habits */}
                            <div className="space-y-4 mb-8">
                                {routine.habits.map((habit) => (
                                    <div key={habit.id} className="flex flex-col md:flex-row md:items-center justify-between bg-indigo-50 p-4 rounded-2xl">
                                        <div className="text-xl font-medium text-gray-700 mb-4 md:mb-0">
                                            {habit.name}
                                        </div>
                                        
                                        <div className="flex items-center gap-4">
                                            {/* Display Badges for this specific habit */}
                                            <div className="flex gap-2">
                                                {habit.badges.map((badge) => (
                                                    <img 
                                                        key={badge.id}
                                                        src={`/storage/${badge.image_path}`} 
                                                        alt="Reward Badge" 
                                                        className="w-12 h-12 rounded-full border-2 border-green-400 object-cover shadow-sm"
                                                    />
                                                ))}
                                            </div>

                                            {/* Complete Button */}
                                            <button
                                                onClick={() => completeHabit(habit.id)}
                                                className="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-6 rounded-full shadow-md transition transform hover:scale-105"
                                            >
                                                Done!
                                            </button>
                                        </div>
                                    </div>
                                ))}
                            </div>

                            {/* Add New Habit Form */}
                            {activeRoutineId === routine.id ? (
                                <form onSubmit={(e) => submitHabit(e, routine.id)} className="flex gap-4">
                                    <input
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        placeholder="e.g., Brush Teeth, Wait Your Turn..."
                                        className="flex-1 rounded-xl border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required
                                    />
                                    <button 
                                        type="submit" 
                                        disabled={processing}
                                        className="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-xl transition"
                                    >
                                        Save
                                    </button>
                                    <button 
                                        type="button" 
                                        onClick={() => setActiveRoutineId(null)}
                                        className="text-gray-500 hover:text-gray-700 px-4"
                                    >
                                        Cancel
                                    </button>
                                </form>
                            ) : (
                                <button 
                                    onClick={() => setActiveRoutineId(routine.id)}
                                    className="text-indigo-500 font-semibold hover:text-indigo-700 transition flex items-center gap-1"
                                >
                                    + Add a new habit
                                </button>
                            )}
                        </div>
                    ))}

                    {routines.length === 0 && (
                        <div className="text-center text-gray-500 p-12 bg-white rounded-3xl shadow-sm">
                            No routines found. We will need to seed the database!
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}