import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome() {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
            {/* Navigation */}
            <nav className="px-6 py-4 flex justify-between items-center">
                <div className="flex items-center space-x-2">
                    <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span className="text-white font-bold text-lg">🎓</span>
                    </div>
                    <span className="text-xl font-bold text-gray-900">EduManage</span>
                </div>
                <div className="space-x-4">
                    <Link href="/login">
                        <Button variant="ghost" className="text-gray-600 hover:text-gray-900">
                            Login
                        </Button>
                    </Link>
                    <Link href="/register">
                        <Button className="bg-blue-600 hover:bg-blue-700">
                            Get Started
                        </Button>
                    </Link>
                </div>
            </nav>

            {/* Hero Section */}
            <div className="px-6 py-12 lg:py-20">
                <div className="max-w-6xl mx-auto text-center">
                    <h1 className="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                        🎓 Complete School Management System
                    </h1>
                    <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Streamline your educational institution with our comprehensive platform. 
                        Manage students, teachers, courses, grades, and attendance all in one place.
                    </p>
                    <div className="space-x-4">
                        <Link href="/register">
                            <Button size="lg" className="bg-blue-600 hover:bg-blue-700 text-lg px-8 py-3">
                                Start Free Trial
                            </Button>
                        </Link>
                        <Link href="/login">
                            <Button size="lg" variant="outline" className="text-lg px-8 py-3">
                                Sign In
                            </Button>
                        </Link>
                    </div>
                </div>

                {/* Feature Grid */}
                <div className="max-w-6xl mx-auto mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <span className="text-2xl">👨‍🎓</span>
                        </div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-2">Student Management</h3>
                        <p className="text-gray-600">
                            Comprehensive student profiles, enrollment tracking, and academic progress monitoring.
                        </p>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <span className="text-2xl">👩‍🏫</span>
                        </div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-2">Teacher Portal</h3>
                        <p className="text-gray-600">
                            Manage courses, record grades, track attendance, and communicate with students.
                        </p>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <span className="text-2xl">📚</span>
                        </div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-2">Course Management</h3>
                        <p className="text-gray-600">
                            Create and organize courses, assign teachers, and manage student enrollments.
                        </p>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div className="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                            <span className="text-2xl">👪</span>
                        </div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-2">Parent Access</h3>
                        <p className="text-gray-600">
                            Parents can view their children's grades, attendance, and academic progress.
                        </p>
                    </div>
                </div>

                {/* Key Features */}
                <div className="max-w-4xl mx-auto mt-16">
                    <h2 className="text-3xl font-bold text-center text-gray-900 mb-12">
                        ✨ Everything You Need to Manage Your School
                    </h2>
                    
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div className="space-y-4">
                            <h3 className="text-xl font-semibold text-gray-900">📊 Academic Tracking</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Grade management and GPA calculation
                                </li>
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Attendance tracking and reports
                                </li>
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Assignment and test score recording
                                </li>
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Academic progress monitoring
                                </li>
                            </ul>
                        </div>

                        <div className="space-y-4">
                            <h3 className="text-xl font-semibold text-gray-900">🏫 Administration</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    User role management (Admin, Teacher, Student, Parent)
                                </li>
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Course creation and scheduling
                                </li>
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Student enrollment management
                                </li>
                                <li className="flex items-center">
                                    <span className="text-green-500 mr-2">✓</span>
                                    Teacher assignment and oversight
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {/* Dashboard Preview */}
                <div className="max-w-6xl mx-auto mt-16">
                    <h2 className="text-3xl font-bold text-center text-gray-900 mb-8">
                        🖥️ Role-Based Dashboards
                    </h2>
                    
                    <div className="bg-white rounded-2xl shadow-2xl p-8">
                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">👨‍💼</span>
                                </div>
                                <h4 className="text-lg font-semibold text-gray-900 mb-2">Admin Dashboard</h4>
                                <p className="text-gray-600 text-sm">
                                    Complete overview with user statistics, system management, and institutional insights.
                                </p>
                            </div>
                            
                            <div className="text-center">
                                <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">👩‍🏫</span>
                                </div>
                                <h4 className="text-lg font-semibold text-gray-900 mb-2">Teacher Dashboard</h4>
                                <p className="text-gray-600 text-sm">
                                    Course management, grade entry, attendance tracking, and student progress.
                                </p>
                            </div>
                            
                            <div className="text-center">
                                <div className="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl">👨‍🎓</span>
                                </div>
                                <h4 className="text-lg font-semibold text-gray-900 mb-2">Student & Parent View</h4>
                                <p className="text-gray-600 text-sm">
                                    Academic progress, grades, attendance records, and course information.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Call to Action */}
                <div className="max-w-4xl mx-auto mt-16 text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-12 text-white">
                    <h2 className="text-3xl font-bold mb-4">Ready to Transform Your School Management? 🚀</h2>
                    <p className="text-xl mb-8 opacity-90">
                        Join hundreds of educational institutions already using EduManage to streamline their operations.
                    </p>
                    <div className="space-x-4">
                        <Link href="/register">
                            <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-3">
                                Start Your Free Trial
                            </Button>
                        </Link>
                        <Link href="/login">
                            <Button size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-3">
                                Login to Your Account
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>

            {/* Footer */}
            <footer className="px-6 py-8 border-t border-gray-200 bg-white">
                <div className="max-w-6xl mx-auto text-center text-gray-600">
                    <p>&copy; 2024 EduManage. Empowering education through technology.</p>
                </div>
            </footer>
        </div>
    );
}